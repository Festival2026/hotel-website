<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">Редактирование: <?= htmlspecialchars($model['page']->title) ?></h2>
    <a href="/hotel/admin/pages/index" class="btn btn-outline-secondary">← Назад к списку</a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-4">
        <form action="/hotel/admin/pages/save" method="POST">
            <input type="hidden" name="id" value="<?= $model['page']->id ?>">
            
            <div class="mb-3">
                <label class="form-label fw-bold">Заголовок страницы (Title)</label>
                <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($model['page']->title) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Содержимое страницы</label>
                <!-- ВАЖНО: id="editor" нужен для инициализации CKEditor -->
                <textarea name="content" id="editor" rows="15" class="form-control"><?= htmlspecialchars($model['page']->content) ?></textarea>
            </div>

            <button type="submit" class="btn btn-success btn-lg px-5">Сохранить изменения</button>
        </form>
    </div>
</div>

<!-- Подключение CKEditor 5 (Classic) через CDN -->
<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>

<!-- Подключение CKEditor 5 через альтернативный CDN -->
<script src="https://cdn.jsdelivr.net/npm/@ckeditor/ckeditor5-build-classic@40.0.0/build/ckeditor.js"></script>

<!-- Подключение CKEditor 4 (он проще и поддерживает картинки из коробки) -->
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>

<!-- Подключение CKEditor 5 -->
<script src="https://cdn.jsdelivr.net/npm/@ckeditor/ckeditor5-build-classic@40.0.0/build/ckeditor.js"></script>

<!-- Подключение CKEditor 5 -->
<script src="https://cdn.jsdelivr.net/npm/@ckeditor/ckeditor5-build-classic@40.0.0/build/ckeditor.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        
        // Кастомный класс для загрузки картинок (Base64)
        class MyUploadAdapter {
            constructor( loader ) { this.loader = loader; }
            upload() {
                return this.loader.file.then( file => new Promise( ( resolve, reject ) => {
                    const reader = new FileReader();
                    reader.onload = () => { resolve( { default: reader.result } ); };
                    reader.onerror = error => { reject( error ); };
                    reader.readAsDataURL( file );
                } ) );
            }
            abort() {}
        }

        // Функция подключения нашего класса к редактору
        function MyCustomUploadAdapterPlugin( editor ) {
            editor.plugins.get( 'FileRepository' ).createUploadAdapter = ( loader ) => {
                return new MyUploadAdapter( loader );
            };
        }

        // Инициализация редактора
        ClassicEditor
            .create( document.querySelector( '#editor' ), {
                language: 'ru',
                extraPlugins: [ MyCustomUploadAdapterPlugin ], // Подключаем наш загрузчик
                toolbar: [ 
                    'heading', '|', 'bold', 'italic', 'link', '|', 
                    'bulletedList', 'numberedList', '|', 
                    'uploadImage', 'insertTable', 'mediaEmbed', '|', 
                    'undo', 'redo' 
                ]
            } )
            .catch( error => {
                console.error( error );
            } );
    });
</script>