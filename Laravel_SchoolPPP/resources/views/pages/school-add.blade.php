
@extends('common.page_wrapper.index')

@section('content')


<div class="row">
    <div class="col-lg-12">
        <!--begin::Portlet-->
        <div class="m-portlet">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <span class="m-portlet__head-icon m--hide">
                            <i class="la la-gear"></i>
                        </span>
                        <h3 class="m-portlet__head-text">
                            Add new school
                        </h3>
                    </div>
                </div>
            </div>
            <!--begin::Form-->
            <form  method="POST" action="/school/create" class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
                {!! csrf_field() !!}
                <div class="m-portlet__body">
                    <div class="form-group required m-form__group row">
                        <div class="col-lg-12 {{$errors->has('school') ? 'has-danger' : ''}}">
                            <label>
                                Name:
                            </label>
                            <input class="form-control" name="name" value="" />
                            @if ($errors->has('name'))
                                <span class="form-control-feedback">{{$errors->first('name')}}</span>
                            @else
                                {{--<span class="form-control-feedback">
                                    Please select school
                                </span>--}}
                            @endif
                        </div>
                    </div>
                </div>
                <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
                    <div class="m-form__actions m-form__actions--solid">
                        <div class="row">
                            <div class="col-lg-6">
                                <button type="submit" class="btn btn-primary">
                                    Save
                                </button>
                                {{-- <button type="reset" class="btn btn-secondary">
                                    Cancel
                                </button> --}}
                            </div>
                            {{-- <div class="col-lg-6 m--align-right">
                                <button type="reset" class="btn btn-danger">
                                    Delete
                                </button>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </form>
            <!--end::Form-->
        </div>
        <!--end::Portlet-->

    </div>
</div>

@endsection



