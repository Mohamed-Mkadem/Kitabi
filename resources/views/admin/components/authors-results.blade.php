@if (count($authors) > 0)
    <div class="grid auth-cat-pub-grid">
        @foreach ($authors as $author)
            <!-- Start Author -->
            <div class="card auth-cat-pub">
                <div class="card-header d-flex j-end">
                    <button class="action-controller">
                        <i class="fa-solid fa-ellipsis-vertical"></i>
                    </button>
                    <ul class="actions-holder">
                        <li>
                            <button class="action-edit-btn modal-controller">تعديل</button>
                            <div class="modal-holder ">
                                <div class="modal new-auth-cat-pub-modal">
                                    <div class="modal-header d-flex j-between a-center gap-1 f-wrap">
                                        <h2>تعديل المؤلّف</h2>
                                        <button class="modal-closer">
                                            <i class="fa-solid fa-close"></i>
                                        </button>
                                    </div>

                                    <form action="{{ route('admin.authors.update', $author) }}" method="post"
                                        class="edit-form">
                                        @csrf
                                        @method('PATCH')
                                        <div class="form-control mb-1">
                                            <label for="name-input" class="required">اسم المؤلّف</label>
                                            <input type="text" name="name" value="{{ $author->name }}"
                                                placeholder="اسم المؤلّف">
                                            <p class="error-message ">هذا الحقل إجباري</p>
                                        </div>

                                        <button type="submit" class="submitBtn mt-1">تعديل

                                        </button>
                                    </form>
                                </div>
                            </div>
                        </li>
                        <li>
                            <button class="action-delete-btn modal-controller">حذف</button>
                            <div class="modal-holder ">
                                <form action="{{ route('admin.authors.destroy', $author) }}" method="post"
                                    class="modal t-center confirm-form">
                                    @csrf
                                    @method('DELETE')
                                    <i class=" fa-solid fa-trash"></i>
                                    <p>
                                        هل أنت متأكد من أنّك تريد حذف هذا المؤلّف ؟
                                    </p>
                                    <div class="buttons d-flex j-center a-center gap-1 f-wrap">
                                        <button class="cancelBtn">إلغاء</button>
                                        <button class="confirmBtn">نعم</button>
                                    </div>
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <h3>{{ $author->name }}</h3>
                    <div class="meta-data ">
                        <p class="count">
                            <i class="fa-solid fa-book"></i>
                            <span>{{ $author->books_count }}</span>
                        </p>
                        <p class="date">
                            <i class="fa-regular fa-clock"></i>
                            <span>{{ $author->created_at->format('d - m - Y') }}</span>
                        </p>
                    </div>
                </div>
            </div>
            <!-- End Author -->
        @endforeach

    </div>
    <!-- Start Pagination -->
    {!! $authors->appends(request()->input())->links() !!}
    <!-- End Pagination -->
@else
    <div class="not-found-wrapper show">
        <i class="fa-solid fa-circle-info"></i>
        <p>لم يتمّ العثور على أيّ نتائج</p>
    </div>
@endif
