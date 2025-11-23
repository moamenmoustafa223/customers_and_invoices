<!-- Modal -->
<div class="modal fade" id="edit_CategoryHolidays{{$categoryHoliday->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{trans('cat_holidays.edit_category')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-left">

                <form action=" {{ route('CategoryHolidays.update', $categoryHoliday->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">

                        <div class="form-group col-md-6">
                            <label for="name">{{trans('cat_holidays.category_name_ar')}}  </label>
                            <input type="text" class="form-control" id="name"  name="name" value="{{ $categoryHoliday->name }}">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="name_en">{{trans('cat_holidays.category_name_en')}}  </label>
                            <input type="text" class="form-control" id="name_en"  name="name_en" value="{{ $categoryHoliday->name_en }}">
                        </div>

                        <div class="form-group col-md-12">
                            <label for="notes">  {{trans('cat_holidays.notes')}} </label>
                            <textarea class="form-control" name="notes" rows="4"> {{ $categoryHoliday->notes }}</textarea>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">{{trans('back.Close')}}</button>
                        <button type="submit" class="btn btn-primary">{{trans('back.Save')}}</button>
                    </div>

                </form>

            </div>

        </div>
    </div>
</div>
