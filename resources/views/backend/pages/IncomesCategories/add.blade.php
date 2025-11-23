<!-- Modal -->
<div class="modal fade" id="add_incomesCategory" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{trans('Incomes.Add_New_Income_Category')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form action=" {{ route('IncomesCategories.store') }}" method="post" enctype="multipart/form-data">
                @csrf

                    <div class="row">

                        <div class="form-group col-md-6">
                            <label for="name_ar">{{trans('Incomes.Name_Category_Ar')}} </label>
                            <b class="text-danger">*</b>
                            <input type="text" class="form-control" id="name_ar"  name="name_ar" placeholder="{{trans('Incomes.Name_Category_Ar')}}" value="{{ old('name_ar') }}">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="name_en">{{trans('Incomes.Name_Category_En')}} </label>
                            <b class="text-danger">*</b>
                            <input type="text" class="form-control" id="name"  name="name_en" placeholder="{{trans('Incomes.Name_Category_En')}}" value="{{ old('name_en') }}">
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
