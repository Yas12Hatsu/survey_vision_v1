<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Encuesta de Satisfacción</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        /* Estilos CSS */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h1 {
            color: #2E9AFE;
            margin-bottom: 20px;
        }

        .thank-you-message {
            font-size: 24px;
            color: #333;
            margin-top: 20px;
            display: none;
        }

        .error-message {
            color: red;
            margin-top: 20px;
            display: none;
        }

        .question-card {
            margin-bottom: 20px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #f9f9f9;
            display: none;
        }

        .question-card.active {
            display: block;
        }

        .question-card h3 {
            margin-bottom: 10px;
            font-size: 18px;
            color: #333;
        }

        .question-card label {
            font-size: 20px;
            margin-bottom: 10px;
            display: block;
            color: #333;
        }

        .emoji-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .emoji-item {
            cursor: pointer;
            margin: 0 10px;
            text-align: center;
            padding: 10px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .emoji-item span {
            font-size: 40px;
            display: block;
        }

        .emoji-item p {
            font-size: 14px;
            color: #333;
            margin-top: 10px;
        }

        .emoji-item.selected {
            background-color: #e0f7fa;
            border: 2px solid #2E9AFE;
        }

        button[type="submit"], button[type="button"] {
            background-color: #2E9AFE;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
        }

        button[type="submit"]:hover, button[type="button"]:hover {
            background-color: #1C6ECA;
        }

        button[type="button"]:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }

        textarea {
            width: 100%;
            height: 100px;
            border-radius: 5px;
            padding: 10px;
            border: 1px solid #ccc;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Encuesta de Satisfacción</h1>
        <p class="thank-you-message">¡GRACIAS POR RESPONDER A ESTA ENCUESTA!</p>
        <p class="error-message"></p>
        <form id="surveyForm" method="POST" action="{{ route('respuesta.guardar') }}">
            @csrf
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            @foreach ($preguntas as $index => $pregunta)
                <div class="question-card {{ $index === 0 ? 'active' : '' }}" data-index="{{ $index }}" data-question-id="{{ $pregunta->id }}">
                    <h3>{{ $pregunta->categoria->nombre ?? 'Sin categoría' }}</h3>
                    <label>{{ $pregunta->texto }}</label>
                    @if ($pregunta->tipo === 'cuantitativa')
                        <div class="emoji-container">
                            @foreach ([1, 2, 3, 4, 5] as $value)
                                <div class="emoji-item" onclick="handleEmojiClick(event, {{ $value }}, {{ $pregunta->id }})">
                                    <span role="img" aria-label="emoji-{{ $value }}">
                                        @if ($value === 1) 😠 @endif
                                        @if ($value === 2) 😟 @endif
                                        @if ($value === 3) 😐 @endif
                                        @if ($value === 4) 🙂 @endif
                                        @if ($value === 5) 😃 @endif
                                    </span>
                                    <p>
                                        @if ($value === 1) Muy Insatisfecho @endif
                                        @if ($value === 2) Insatisfecho @endif
                                        @if ($value === 3) Neutral @endif
                                        @if ($value === 4) Satisfecho @endif
                                        @if ($value === 5) Muy Satisfecho @endif
                                    </p>
                                </div>
                            @endforeach
                        </div>
                        <input type="hidden" name="respuestas[{{ $pregunta->id }}][id_pregunta]" value="{{ $pregunta->id }}">
                        <input type="hidden" name="respuestas[{{ $pregunta->id }}][respuesta_cuanti]" id="respuesta_cuanti_{{ $pregunta->id }}">
                    @else
                        <textarea name="respuestas[{{ $pregunta->id }}][respuesta_cuali]"></textarea>
                        <input type="hidden" name="respuestas[{{ $pregunta->id }}][id_pregunta]" value="{{ $pregunta->id }}">
                    @endif
                </div>
            @endforeach
            <button type="button" id="nextBtn" onclick="handleNext()">Siguiente</button>
            <button type="submit" id="submitBtn" style="display: none;">Finalizar</button>
        </form>
    </div>
    <script>
        // JavaScript para manejar la lógica de la encuesta y mostrar mensajes
        let currentQuestionIndex = 0;
        const questions = document.querySelectorAll('.question-card');
        const nextBtn = document.getElementById('nextBtn');
        const submitBtn = document.getElementById('submitBtn');
        const thankYouMessage = document.querySelector('.thank-you-message');
        const errorMessage = document.querySelector('.error-message');

        function handleEmojiClick(event, value, id) {
            // Almacena la respuesta cuantitativa en el campo correspondiente
            document.getElementById('respuesta_cuanti_' + id).value = value;
            const emojis = document.querySelectorAll(`[data-index="${currentQuestionIndex}"] .emoji-item`);
            emojis.forEach(emoji => {
                emoji.classList.remove('selected');
            });
            event.currentTarget.classList.add('selected');
        }

        async function saveResponse() {
            const currentQuestion = questions[currentQuestionIndex];
            const questionId = currentQuestion.dataset.questionId;

            let response = null;

            // Determinar si la pregunta es cuantitativa o cualitativa
            if (currentQuestion.querySelector('input[name^="respuestas"][name$="[respuesta_cuanti]"]')) {
                response = currentQuestion.querySelector('input[name^="respuestas"][name$="[respuesta_cuanti]"]').value;
            } else if (currentQuestion.querySelector('textarea[name^="respuestas"][name$="[respuesta_cuali]"]')) {
                response = currentQuestion.querySelector('textarea[name^="respuestas"][name$="[respuesta_cuali]"]').value;
            }

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            try {
                const res = await fetch('{{ route("respuesta.guardar") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({
                        id_encuesta: 1, // Cambia según tu lógica
                        id_pregunta: questionId,
                        respuesta_cuanti: currentQuestion.querySelector('input[name^="respuestas"][name$="[respuesta_cuanti]"]') ? response : null,
                        respuesta_cuali: currentQuestion.querySelector('textarea[name^="respuestas"][name$="[respuesta_cuali]"]') ? response : null,
                    }),
                });

                if (!res.ok) {
                    const errorText = await res.text();
                    throw new Error(`Error en la respuesta del servidor: ${errorText}`);
                }

                const jsonResponse = await res.json();
                console.log(jsonResponse.message);
            } catch (error) {
                console.error('Error:', error.message);
                errorMessage.textContent = 'Hubo un error al guardar la respuesta. Inténtalo de nuevo.';
                errorMessage.style.display = 'block';
            }
        }

        function handleNext() {
            const currentQuestion = questions[currentQuestionIndex];
            const isCuantitativa = currentQuestion.querySelector('input[name^="respuestas"][name$="[respuesta_cuanti]"]');
            const hasSelectedEmoji = isCuantitativa && !!currentQuestion.querySelector('.emoji-item.selected');
            const isCualitativa = currentQuestion.querySelector('textarea[name^="respuestas"][name$="[respuesta_cuali]"]');
            const hasTextResponse = isCualitativa && !!currentQuestion.querySelector('textarea[name^="respuestas"][name$="[respuesta_cuali]"]').value.trim();

            if ((isCuantitativa && hasSelectedEmoji) || (isCualitativa && hasTextResponse)) {
                // Guarda la respuesta antes de pasar a la siguiente pregunta
                saveResponse().then(() => {
                    currentQuestion.classList.remove('active');
                    currentQuestionIndex++;
                    if (currentQuestionIndex < questions.length) {
                        questions[currentQuestionIndex].classList.add('active');
                    } else {
                        thankYouMessage.style.display = 'block';
                        nextBtn.style.display = 'none';
                        submitBtn.style.display = 'block';
                    }
                });
            } else {
                errorMessage.textContent = 'Por favor, responde a la pregunta antes de continuar.';
                errorMessage.style.display = 'block';
            }
        }
    </script>
</body>
</html>
