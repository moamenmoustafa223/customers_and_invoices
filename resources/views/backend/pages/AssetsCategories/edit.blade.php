<!-- Modal -->
<div class="modal fade" id="edit_AssetsCategory{{$assetsCategory->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{trans('back.edit_AssetsCategory')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form action=" {{ route('AssetsCategories.update', $assetsCategory->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">

                        <div class="form-group col-md-6">
                            <label for="name_ar">{{trans('Expenses.Name_Category_Ar')}} </label>
                            <b class="text-danger">*</b>
                            <input type="text" class="form-control" id="name_ar"  name="name_ar" value="{{ $assetsCategory->name_ar }}">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="name_en">{{trans('Expenses.Name_Category_En')}}  </label>
                            <b class="text-danger">*</b>
                            <input type="text" class="form-control" id="name_en"  name="name_en" value="{{ $assetsCategory->name_en }}">
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
