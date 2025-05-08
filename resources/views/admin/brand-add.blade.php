@extends('layouts.admin')
@section('content')
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Добавление бренда</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{route('admin.index')}}">
                            <div class="text-tiny">Панель</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <a href="{{route('admin.brands')}}">
                            <div class="text-tiny">Бренд</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">New Бренд</div>
                    </li>
                </ul>
            </div>
            <!-- new-category -->
            <div class="wg-box">
                <form class="form-new-product form-style-1" action="{{route ('admin.brand.store')}}" method="POST" enctype="multipart/form-data">
                   @csrf
                    <fieldset class="name">
                        <div class="body-title">Название бренда <span class="tf-color-1">*</span></div>
                        <input class="flex-grow" type="text" placeholder="Название бренда" name="name" tabindex="0" value="{{old('name')}}" aria-required="true" required="">
                    </fieldset>
                    @error('name')<span class = "alert alert-danger text-center">{{$message}}</span> @enderror
                    <fieldset class="name">
                        <div class="body-title">Ключевое слово <span class="tf-color-1">*</span></div>
                        <input class="flex-grow" type="text" placeholder="Ключевое слово" name="slug" tabindex="0" value="{{old('slug')}}" aria-required="true" required="">
                    </fieldset>
                    @error('slug')<span class = "alert alert-danger text-center">{{$message}}</span> @enderror
                    <fieldset>
                        <div class="body-title">Загрузите изображение <span class="tf-color-1">*</span>
                        </div>
                        <div class="upload-image flex-grow">
                            <div class="item" id="imgpreview" style="display:none">
                                <img src="upload-1.html" class="effect8" alt="">
                            </div>
                            <div id="upload-file" class="item up-load">
                                <label class="uploadfile" for="myFile">
                                                        <span class="icon">
                                                            <i class="icon-upload-cloud"></i>
                                                        </span>
                                    <span class="body-text">Разместите свои изображения здесь или  <span
                                            class="tf-color">нажмите чтобы посмотреть</span></span>
                                    <input type="file" id="myFile" name="image" accept="image/*">
                                </label>
                            </div>
                        </div>
                    </fieldset>
                    @error('image')<span class = "alert alert-danger text-center">{{$message}}</span> @enderror
                    <div class="bot">
                        <div></div>
                        <button class="tf-button w208" type="submit">Сохранить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(function() {
            // Обработка загрузки изображения
            $("#myFile").on("change", function(e) {
                const [file] = this.files;
                if (file) {
                    $("#imgpreview img").attr('src', URL.createObjectURL(file));
                    $("#imgpreview").show();
                }
            });

            // Генерация slug при вводе названия
            $("input[name='name']").on("input", function() {
                $("input[name='slug']").val(generateSlug($(this).val()));
            });
        });

        // Функция для транслитерации русских символов
        function transliterate(text) {
            const cyrToLatMap = {
                'а': 'a', 'б': 'b', 'в': 'v', 'г': 'g', 'д': 'd', 'е': 'e',
                'ё': 'yo', 'ж': 'zh', 'з': 'z', 'и': 'i', 'й': 'y', 'к': 'k',
                'л': 'l', 'м': 'm', 'н': 'n', 'о': 'o', 'п': 'p', 'р': 'r',
                'с': 's', 'т': 't', 'у': 'u', 'ф': 'f', 'х': 'h', 'ц': 'ts',
                'ч': 'ch', 'ш': 'sh', 'щ': 'sch', 'ъ': '', 'ы': 'y', 'ь': '',
                'э': 'e', 'ю': 'yu', 'я': 'ya',
                ' ': '-', '_': '-'
            };

            return text.toLowerCase().split('').map(function(char) {
                return cyrToLatMap[char] || char;
            }).join('');
        }

        // Улучшенная функция генерации slug
        function generateSlug(text) {
            // Транслитерируем русские символы
            let slug = transliterate(text);

            // Заменяем все не-латинские символы и лишние дефисы
            slug = slug.replace(/[^a-z0-9-]/g, '') // Удаляем все кроме букв, цифр и дефисов
                .replace(/-+/g, '-')       // Удаляем повторяющиеся дефисы
                .replace(/^-|-$/g, '');     // Удаляем дефисы в начале и конце

            return slug;
        }
    </script>

@endpush
