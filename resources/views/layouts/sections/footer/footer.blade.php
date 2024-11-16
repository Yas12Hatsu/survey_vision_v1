@php
$containerFooter = !empty($containerNav) ? $containerNav : 'container-fluid';
@endphp

<!-- Footer -->
<footer class="content-footer footer bg-footer-theme">
  <div class="{{ $containerFooter }}">
    <div class="footer-container d-flex align-items-center justify-content-between py-4 flex-md-row flex-column">
      <div class="text-body">
        © <script>document.write(new Date().getFullYear())</script>, hecho por SmartData BI Consultoría 
        <a href="{{ (!empty(config('variables.creatorUrl')) ? config('variables.creatorUrl') : '') }}" target="_blank" class="footer-link"><!--{{ (!empty(config('variables.creatorName')) ? config('variables.creatorName') : '') }}--></a>
      </div>
      <div>
        <!-- Botón para abrir el modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#privacyModal">
          Ver Aviso de Privacidad
        </button>
      </div>
    </div>
  </div>
</footer>
<!--/ Footer -->

<!-- Modal -->
<div class="modal fade" id="privacyModal" tabindex="-1" role="dialog" aria-labelledby="privacyModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="privacyModalLabel">Aviso de Privacidad</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><strong>Aviso de Privacidad</strong></p>
                <p>En SurveyVision - SmartData BI nos comprometemos a proteger la privacidad de nuestros usuarios. Este aviso de privacidad explica nuestras prácticas en relación con la información recopilada a través de nuestra aplicación web.</p>
                
                <p><strong>Recopilación y Uso de Información</strong></p>
                <p>Nuestra aplicación de encuestas de satisfacción no recopila, almacena ni procesa datos personales identificables de los usuarios. Las encuestas que ofrecemos están diseñadas para obtener comentarios sobre la satisfacción del usuario sin requerir información personal.</p>

                <p><strong>Información Recopilada</strong></p>
                <p>Solo recopilamos respuestas anónimas a las preguntas de nuestras encuestas. Estas respuestas no contienen información personal y se utilizan únicamente con el fin de mejorar nuestros servicios y entender mejor las necesidades y expectativas de nuestros usuarios.</p>

                <p><strong>Seguridad</strong></p>
                <p>Nos tomamos muy en serio la seguridad de la información. Implementamos medidas técnicas y organizativas adecuadas para proteger las respuestas de nuestras encuestas contra el acceso no autorizado, la pérdida o el uso indebido.</p>

                <p><strong>Cambios a Este Aviso de Privacidad</strong></p>
                <p>Nos reservamos el derecho de actualizar este aviso de privacidad en cualquier momento. Cualquier cambio será publicado en esta página y entrará en vigor inmediatamente después de su publicación. Recomendamos revisar periódicamente este aviso para estar informado sobre cómo protegemos la información que recopilamos.</p>

                <p><strong>Contacto</strong></p>
                <p>Si tienes alguna pregunta o inquietud sobre este aviso de privacidad, no dudes en contactarnos a través de <a href="mailto:jatziryhh44@gmail.com">jatziryhh44@gmail.com</a>.</p>

                <p><strong>Fecha de Efectividad</strong></p>
                <p>Este aviso de privacidad es efectivo a partir de Octubre 2024.</p>
            </div>
        </div>
    </div>
</div>

<!-- Scripts de Bootstrap -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
