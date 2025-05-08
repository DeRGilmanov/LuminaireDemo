@extends('layouts.admin')
@section('content')
    <div class="main-content" >

        <!-- main-content-wrap -->
        <div class="main-content-inner">
            <!-- main-content-wrap -->
            <div class="main-content-wrap">
                <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                    <h3>Добавить товар</h3>
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
                            <a href="{{route('admin.products')}}">
                                <div class="text-tiny">Товар</div>
                            </a>
                        </li>
                        <li>
                            <i class="icon-chevron-right"></i>
                        </li>
                        <li>
                            <div class="text-tiny">Добавить товар</div>
                        </li>
                    </ul>
                </div>
                <!-- form-add-product -->
                <form class="tf-section-2 form-add-product" method="POST" enctype="multipart/form-data" action="{{route('admin.product.store')}}">
                    @csrf
                    <div class="wg-box">
                        <fieldset class="name">
                            <div class="body-title mb-10">Название товара <span class="tf-color-1">*</span>
                            </div>
                            <input class="mb-10" type="text" placeholder="Введите название продукта" name="name" tabindex="0" value="{{old('name')}}" aria-required="true" required="">
                            <div class="text-tiny">При вводе названия продукта его длина не должна превышать 100 символов.</div>
                        </fieldset>
                        @error('name') <span class="alert alert-danger text-center">{{$message}}</span> @enderror
                        <fieldset class="name">
                            <div class="body-title mb-10">Ключевое слово <span class="tf-color-1">*</span></div>
                            <input class="mb-10" type="text" placeholder="Введите ключевое слово " name="slug" tabindex="0" value="{{old('slug')}}" aria-required="true" required="">
                            <div class="text-tiny">При вводе названия продукта его длина не должна превышать 100 символов.</div>
                        </fieldset>
                            @error('slug') <span class="alert alert-danger text-center">{{$message}}</span> @enderror
                        <div class="gap22 cols">
                            <fieldset class="category">
                                <div class="body-title mb-10">Категория <span class="tf-color-1">*</span>
                                </div>
                                <div class="select">
                                    <select class="" name="category_id">
                                        <option>Выберите категорию</option>
                                        @foreach($categories as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </fieldset>
                            @error('category_id') <span class="alert alert-danger text-center">{{$message}}</span> @enderror
                            <fieldset class="brand">
                                <div class="body-title mb-10">Бренд <span class="tf-color-1">*</span>
                                </div>
                                <div class="select">
                                    <select class="" name="brand_id">
                                        <option>Выберите бренд</option>
                                        @foreach($brands as $brand)
                                        <option value="{{$brand->id}}">{{$brand->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </fieldset>
                                @error('brand_id') <span class="alert alert-danger text-center">{{$message}}</span> @enderror
                        </div>

                        <fieldset class="shortdescription">
                            <div class="body-title mb-10">Краткое описание <span class="tf-color-1">*</span></div>
                            <textarea class="mb-10 ht-150" name="short_description" placeholder="Краткое описание" tabindex="0" aria-required="true" required="{{old('short_description')}}"></textarea>
                            <div class="text-tiny">При вводе названия продукта длина текста не должна превышать 100 символов.</div>
                        </fieldset>
                                @error('short_description') <span class="alert alert-danger text-center">{{$message}}</span> @enderror
                        <fieldset class="description">
                            <div class="body-title mb-10">Описание <span class="tf-color-1">*</span>
                            </div>
                            <textarea class="mb-10" name="description" placeholder="Описание" tabindex="0" aria-required="true" required="{{old('description')}}"></textarea>
                            <div class="text-tiny">При вводе названия продукта длина текста не должна превышать 100 символов.</div>
                        </fieldset>
                                    @error('description') <span class="alert alert-danger text-center">{{$message}}</span> @enderror
                    </div>
                    <div class="wg-box">
                        <fieldset>
                            <div class="body-title">Загрузите изображение <span class="tf-color-1">*</span>
                            </div>
                            <div class="upload-image flex-grow">
                                <div class="item" id="imgpreview" style="display:none">
                                    <img src="../../../localhost_8000/images/upload/upload-1.png" class="effect8" alt="">
                                </div>
                                <div id="upload-file" class="item up-load">
                                    <label class="uploadfile" for="myFile">
                                                        <span class="icon">
                                                            <i class="icon-upload-cloud"></i>
                                                        </span>
                                        <span class="body-text">Разместите свои изображения здесь<span class="tf-color"> или выберите нажмите для просмотра</span></span>
                                        <input type="file" id="myFile" name="image" accept="image/*">
                                    </label>
                                </div>
                            </div>
                        </fieldset>
                        @error('image') <span class="alert alert-danger text-center">{{$message}}</span> @enderror
                        <fieldset>
                            <div class="body-title mb-10">Загружайте изображения в галерею</div>
                            <div class="upload-image mb-16">
                                <!-- <div class="item">
                <img src="images/upload/upload-1.png" alt="">
            </div>                                                 -->
                                <div id="galUpload" class="item up-load">
                                    <label class="uploadfile" for="gFile">
                                                        <span class="icon">
                                                            <i class="icon-upload-cloud"></i>
                                                        </span>
                                        <span class="text-tiny">Разместите свои изображения здесь<span class="tf-color"> или выберите нажмите для просмотра</span></span>
                                        <input type="file" id="gFile" name="images[]" accept="image/*"
                                               multiple="">
                                    </label>
                                </div>
                            </div>
                        </fieldset>
                            @error('images') <span class="alert alert-danger text-center">{{$message}}</span> @enderror
                        <div class="cols gap22">
                            <fieldset class="name">
                                <div class="body-title mb-10">Обычная цена <span
                                        class="tf-color-1">*</span></div>
                                <input class="mb-10" type="text" placeholder="Введите обычную цену" name="regular_price" tabindex="0" value="{{old('regular_price')}}" aria-required="true" required="">
                            </fieldset>
                            @error('regular_price') <span class="alert alert-danger text-center">{{$message}}</span> @enderror
                            <fieldset class="name">
                                <div class="body-title mb-10">Цена со скидкой<span
                                        class="tf-color-1">*</span></div>
                                <input class="mb-10" type="text" placeholder="Введите цену со скидкой" name="sale_price" tabindex="0" value="{{old('sale_price')}}" aria-required="true" required="">
                            </fieldset>
                                @error('sale_price') <span class="alert alert-danger text-center">{{$message}}</span> @enderror
                        </div>


                        <div class="cols gap22">
                            <fieldset class="name">
                                <div class="body-title mb-10">Артикул <span class="tf-color-1">*</span>
                                </div>
                                <input class="mb-10" type="text" placeholder="Введите артикул" name="SKU" tabindex="0" value="{{old('SKU')}}" aria-required="true" required="">
                            </fieldset>
                            @error('SKU') <span class="alert alert-danger text-center">{{$message}}</span> @enderror
                            <fieldset class="name">
                                <div class="body-title mb-10">Количество <span class="tf-color-1">*</span>
                                </div>
                                <input class="mb-10" type="text" placeholder="Введите количество" name="quantity" tabindex="0" value="{{old('quantity')}}" aria-required="true" required="">
                            </fieldset>
                                @error('quantity') <span class="alert alert-danger text-center">{{$message}}</span> @enderror
                        </div>

                        <div class="cols gap22">
                            <fieldset class="name">
                                <div class="body-title mb-10">Склад</div>
                                <div class="select mb-10">
                                    <select class="" name="stock_status">
                                        <option value="instock">В наличии</option>
                                        <option value="outofstock">Нет в наличии</option>
                                    </select>
                                </div>
                            </fieldset>
                            @error('stock_status') <span class="alert alert-danger text-center">{{$message}}</span> @enderror
                            <fieldset class="name">
                                <div class="body-title mb-10">Избранное</div>
                                <div class="select mb-10">
                                    <select class="" name="featured">
                                        <option value="0">Нет</option>
                                        <option value="1">Да</option>
                                    </select>
                                </div>
                            </fieldset>
                                @error('featured') <span class="alert alert-danger text-center">{{$message}} </span>@enderror
                        </div>
                        <div class="cols gap10">
                            <button class="tf-button w-full" type="submit">Добавить товар</button>
                        </div>
                    </div>
                </form>
                <!-- /form-add-product -->
            </div>
            <!-- /main-content-wrap -->
        </div>
        <!-- /main-content-wrap -->


@endsection
@push('scripts')
    <script>
        $(function() {
            $("#myFile").on("change", function(e) {
                const [file] = this.files;
                if (file) {
                    $("#imgpreview img").attr('src', URL.createObjectURL(file));
                    $("#imgpreview").show();
                }
            });

                $("#gFile").on("change", function(e) {
                    const gphotos = this.files;
                    $.each(gphotos,function (key,val){
                        $("#galUpload").prepend(`<div class ="item gitems"><img src="${URL.createObjectURL(val)}"/> </div>`)
                    });
                });

            $("input[name='name']").on("input", function() {
                $("input[name='slug']").val(StringToSlug($(this).val()));
            });
        });

        // Функция транслитерации русских символов в латиницу
        function transliterate(word) {
            const converter = {
                'а': 'a', 'б': 'b', 'в': 'v', 'г': 'g', 'д': 'd',
                'е': 'e', 'ё': 'yo', 'ж': 'zh', 'з': 'z', 'и': 'i',
                'й': 'y', 'к': 'k', 'л': 'l', 'м': 'm', 'н': 'n',
                'о': 'o', 'п': 'p', 'р': 'r', 'с': 's', 'т': 't',
                'у': 'u', 'ф': 'f', 'х': 'h', 'ц': 'ts', 'ч': 'ch',
                'ш': 'sh', 'щ': 'sch', 'ъ': '', 'ы': 'y', 'ь': '',
                'э': 'e', 'ю': 'yu', 'я': 'ya'
            };

            return word.toLowerCase().split('').map(char => {
                return converter[char] || char;
            }).join('');
        }

        // Обновленная функция генерации slug
        function StringToSlug(text) {
            // Транслитерируем русские символы
            const transliterated = transliterate(text);

            // Заменяем спецсимволы и пробелы
            return transliterated
                .replace(/[^\w\s-]+/g, '')  // Удаляем лишние символы
                .replace(/\s+/g, '-')       // Заменяем пробелы на дефисы
                .replace(/-+/g, '-')       // Удаляем двойные дефисы
                .toLowerCase();
        }
    </script>

@endpush

