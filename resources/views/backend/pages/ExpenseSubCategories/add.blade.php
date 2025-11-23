<!-- Modal -->
<div class="modal fade" id="add_ExpenseSubCategory" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{trans('back.ExpenseSubCategory_add')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form action=" {{ route('ExpenseSubCategories.store') }}" method="post" enctype="multipart/form-data">
                @csrf

                    <div class="row">

                        <div class="col-4">
                            <label for="expense_category_id">{{trans('back.MainCategory')}}</label>
                            <select name="expense_category_id" class="form-control">
                                <option value="">{{trans('back.select_category')}}</option>
                                @foreach(App\Models\ExpenseCategory::all() as $expenseCategory)
                                    <option value="{{ $expenseCategory->id }}" {{ old('expense_category_id') == $expenseCategory->id ? 'selected' : null }}>
                                        @if(app()->getLocale() == 'ar')
                                            {{ $expenseCategory->name_ar }}
                                        @else
                                            {{ $expenseCategory->name_en }}
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="name_ar">{{trans('Expenses.Name_Category_Ar')}} </label>
                            <b class="text-danger">*</b>
                            <input type="text" class="form-control" id="name_ar"  name="name_ar" placeholder="{{trans('Expenses.Name_Category_Ar')}}" value="{{ old('name_ar') }}">
                        </div>

                        <div class="form-group col-md-4">
                            <label for="name_en">{{trans('Expenses.Name_Category_En')}} </label>
                            <b class="text-danger">*</b>
                            <input type="text" class="form-control" id="name"  name="name_en" placeholder="{{trans('Expenses.Name_Category_En')}}" value="{{ old('name_en') }}">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">{{trans('back.Close')}}</button>
                        <button type="submit" class="btn btn-success">{{trans('back.Add')}}</button>
                    </div>

                </form>

            </div>

        </div>
    </div>
</div>
