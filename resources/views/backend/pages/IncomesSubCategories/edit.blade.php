<!-- Modal -->
<div class="modal fade" id="edit_IncomesSubCategory{{$incomesSubCategory->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{trans('back.IncomesSubCategory_edit')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-left">

                <form action=" {{ route('IncomesSubCategories.update', $incomesSubCategory->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">

                        <div class="form-group col-md-4">
                            <label for="" class="font-weight-bold">
                                {{trans('Expenses.select_Category')}}
                            </label>
                            <b class="text-danger">*</b>
                            <select class="form-control" name="expense_category_id" required>
                                <option value="">{{trans('back.select_category')}}</option>
                                @foreach(App\Models\IncomesCategory::all() as $incomesCategory)
                                    <option value="{{ $incomesCategory->id }}" {{ old('incomes_category_id', $incomesSubCategory->expense_category_id) == $incomesCategory->id ? 'selected' : null }}>
                                        @if (app()->getLocale() == 'ar')
                                            {{ $incomesCategory->name_ar ?? "" }}
                                        @else
                                            {{ $incomesCategory->name_en ?? "" }}
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="name_ar">{{trans('Expenses.Name_Category_Ar')}} </label>
                            <b class="text-danger">*</b>
                            <input type="text" class="form-control" id="name_ar"  name="name_ar" value="{{ $incomesSubCategory->name_ar }}">
                        </div>

                        <div class="form-group col-md-4">
                            <label for="name_en">{{trans('Expenses.Name_Category_En')}}  </label>
                            <b class="text-danger">*</b>
                            <input type="text" class="form-control" id="name_en"  name="name_en" value="{{ $incomesSubCategory->name_en }}">
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">{{trans('back.Close')}}</button>
                        <button type="submit" class="btn btn-success">{{trans('back.Save')}}</button>
                    </div>

                </form>

            </div>

        </div>
    </div>
</div>
