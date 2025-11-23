<!-- Modal -->
<div class="modal fade" id="delete_expenseCategory{{$expenseCategory->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{trans('Expenses.Delete_Expense_Category')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form action="{{route('ExpenseCategories.destroy', $expenseCategory->id)}}" method="post">
                    @csrf
                    @method('DELETE')
                    <div class="text-center" >

                        <h4>
                            {{trans('Expenses.Are you sure to delete?')}}
                            <br>
                            <br>
                            @if (app()->getLocale() == 'ar')
                                {{ $expenseCategory->name_ar }}
                            @else
                                {{ $expenseCategory->name_en }}
                            @endif
                        </h4>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">{{trans('back.close')}} </button>
                        <button type="submit" class="btn btn-danger">{{trans('back.Delete')}}</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
