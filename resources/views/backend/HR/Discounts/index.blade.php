@extends('backend.layouts.master')

@section('page_title')
    {{trans('discounts.discounts')}}
@endsection

@section('content')

    <div class="row">
        @can('Discounts_add')
            <div class="col-md-9 mb-1">
                <a class="btn btn-primary btn-sm" href="{{route('Discounts.create')}}">
                    <i class="mdi mdi-plus"></i>
                    {{trans('discounts.add_new_discount')}}
                </a>
            </div>
        @endcan

        <div class="col-md-3 mb-1">
            <form action="{{ route('Discounts.index') }}" method="GET" role="search">
                <div class="input-group">
                    <input type="text" class="form-control form-control-sm" name="query"
                           value="{{old('query', request()->input('query'))}}" placeholder="search..." id="query">
                    <button class="btn btn-primary btn-sm ml-1" type="submit" title="Search">
                        <span class="fas fa-search"></span>
                    </button>
                    <a href="{{ route('Discounts.index') }}" class="btn btn-success btn-sm ml-1 " type="button"
                       title="Reload">
                        <span class="fas fa-sync-alt"></span>
                    </a>
                </div>
            </form>
        </div>

    </div>

    <div class="row">
        <div class="col-12">
            <div class="card-box">

                <div class="table-responsive">
                    <table class="table text-center  table-bordered table-sm ">
                        <thead>
                        <tr style="background-color: rgb(232,245,252)">
                            <th>#</th>
                            <th> {{trans('discounts.discount_name')}}</th>
                            <th> {{trans('discounts.Employee_name')}}</th>
                            <th> {{trans('discounts.category_name')}}</th>
                            <th> {{trans('discounts.amount')}}</th>
                            <th> {{trans('back.payment_methods')}}</th>
                            <th> {{trans('discounts.date')}}</th>
                            <th> {{trans('discounts.Created_at')}}</th>
                            <th> {{trans('discounts.Action')}}</th>
                        </tr>
                        </thead>

                        @php $i=1 @endphp

                        <tbody>
                        @foreach($discounts as $key=> $discount)
                            <tr>
                                <td>{{$key+ $discounts->firstItem()}}</td>
                                <td> {{ $discount->name }}</td>
                                <td>
                                    <a href="{{route('Employees.show', $discount->Employee->id )}}"
                                       class="font-weight-bold">
                                        @if (app()->getLocale() == 'ar')
                                            {{ $discount->Employee->name_ar }}
                                            <br>
                                            {{ $discount->Employee->phone }}
                                        @else
                                            {{ $discount->Employee->name_en }}
                                            <br>
                                            {{ $discount->Employee->phone }}
                                        @endif
                                    </a>
                                </td>
                                <td>
                                    @if (app()->getLocale() == 'ar')
                                        {{ $discount->CategoryDiscount->name }}
                                    @else
                                        {{ $discount->CategoryDiscount->name_en }}
                                    @endif
                                </td>
                                <td>{{ $discount->amount }}</td>
                                <td> @if(app()->getLocale() == 'ar' ) {{ $discount->Payment_method->name_ar }} @else {{ $discount->Payment_method->name_en }} @endif</td>

                                <td>{{ $discount->date }}</td>
                                <td>{{ $discount->created_at }}</td>

                                <td class="text-center">

                                    {{-- Edit --}}
                                    @can('Discounts_edit')
                                        <a href="{{ route('Discounts.edit', $discount->id) }}"
                                           class="text-success mx-1"
                                           title="{{ trans('back.edit') }}">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @endcan
                                
                                    {{-- Delete --}}
                                    @can('Discounts_delete')
                                        <a href="#"
                                           class="text-danger mx-1"
                                           title="{{ trans('back.delete') }}"
                                           data-bs-toggle="modal"
                                           data-bs-target="#delete_Discounts{{ $discount->id }}">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                        @include('backend.HR.Discounts.delete')
                                    @endcan
                                
                                </td>
                                
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                {!! $discounts->appends(Request::all())->links() !!}

            </div>
        </div>
    </div>

@endsection



@section('js')

    <script>

    </script>

@endsection


