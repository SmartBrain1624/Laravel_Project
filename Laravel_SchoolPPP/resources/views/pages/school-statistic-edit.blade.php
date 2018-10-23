
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
                            Edit data
                        </h3>
                    </div>
                </div>
            </div>
            <!--begin::Form-->
            <form  method="POST" action="/school/data/{{ $datas->id }}/edit" class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
                {!! csrf_field() !!}
                <div class="m-portlet__body">
                    <div class="form-group required m-form__group row">
                        <div class="col-lg-12 {{$errors->has('school') ? 'has-danger' : ''}}">
                            <label>
                                School:
                            </label>
                            <select class="form-control" name="school">
                                <option value="0" selected disabled>Select school</option>
                                @foreach($schools as $school)
                                    <option @if($school->id == $statistics->school_id) selected @endif value="{{$school->id}}">{{$school->name}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('school'))
                                <span class="form-control-feedback">{{$errors->first('school')}}</span>
                            @else
                                {{--<span class="form-control-feedback">
                                    Please select school
                                </span>--}}
                            @endif

                        </div>

                    </div>
                    <div class="form-group required m-form__group row">
                        <div class="col-lg-4 {{$errors->has('year') ? 'has-danger' : ''}}">
                            <label class="">
                                Year
                            </label>
                            <select class="form-control" name="year">
                                @foreach($years as $year)
                                        <option @if($year == $statistics->year) selected @endif value="{{$year}}">{{$year}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('year'))
                                <span class="form-control-feedback">{{$errors->first('year')}}</span>
                            @else
                                {{--<span class="form-control-feedback">
                                    Please select year
                                </span>--}}
                            @endif

                        </div>
                        <div class="col-lg-4 {{$errors->has('week') ? 'has-danger' : ''}}">
                            <label>
                                Week:
                            </label>
                            <div class="m-input-icon m-input-icon--right">
                                <select class="form-control" name="week">
                                    @foreach($weeks as $week)
                                        <option @if($week == $statistics->week) selected @endif value="{{$week}}">{{$week}}</option>
                                    @endforeach
                                </select>
                                {{--<span class="m-input-icon__icon m-input-icon__icon--right">
                                    <span>
                                        <i class="la la-calendar"></i>
                                    </span>
                                </span>--}}
                            </div>
                             @if ($errors->has('week'))
                                <span class="form-control-feedback">{{$errors->first('week')}}</span>
                            @else
                                {{--<span class="form-control-feedback">
                                    Please select week
                                </span>--}}
                            @endif
                        </div>

                        <div class="col-lg-4 {{$errors->has('month') ? 'has-danger' : ''}}">
                            <label>
                                Month:
                            </label>
                            <div class="m-input-icon m-input-icon--right">
                                <select class="form-control" name="month">
                                    @foreach($months as $key => $month)
                                        <option @if($key == $statistics->month) selected @endif value="{{$key}}">{{$month}}</option>
                                    @endforeach
                                </select>
                                {{--<span class="m-input-icon__icon m-input-icon__icon--right">
                                    <span>
                                        <i class="la la-calendar"></i>
                                    </span>
                                </span>--}}
                            </div>
                             @if ($errors->has('month'))
                                <span class="form-control-feedback">{{$errors->first('month')}}</span>
                            @else
                                {{--<span class="form-control-feedback">
                                    Please select month
                                </span>--}}
                            @endif
                        </div>

                    </div>
                    <div class="form-group required m-form__group row">
                        <div class="col-lg-6  {{$errors->has('electricity_euro') ? 'has-danger' : ''}}">
                                <label>
                                    Electricity Euro:
                                </label>
                                    <input
                                        type="text"
                                        class="form-control m-input"
                                        placeholder="Electricity Euro"
                                        name="electricity_euro"
                                        value="{{ $statistics->elect_eur }}">
                                @if ($errors->has('electricity_euro'))
                                    <span class="form-control-feedback">{{$errors->first('electricity_euro')}}</span>
                                @else
                                    {{--<span class="form-control-feedback">
                                        Please enter value
                                    </span>--}}
                                @endif
                        </div>

                        <div class="col-lg-6   {{$errors->has('electricity_kwh') ? 'has-danger' : ''}}">
                                <label>
                                    Electricity kWH
                                </label>
                                    <input
                                        type="text"
                                        class="form-control m-input"
                                        placeholder="Electricity kWH"
                                        name="electricity_kwh"
                                        value="{{ $statistics->elect_kwh }}">
                                @if ($errors->has('electricity_kwh'))
                                    <span class="form-control-feedback">{{$errors->first('electricity_kwh')}}</span>
                                @else
                                    {{--<span class="form-control-feedback">
                                        Please enter value
                                    </span>--}}
                                @endif
                        </div>
                    </div>


                    <div class="form-group required m-form__group row">
                        <div class="col-lg-6   {{$errors->has('heating_euro') ? 'has-danger' : ''}}">
                                <label>
                                    Heating Euro:
                                </label>
                                    <input
                                        type="text"
                                        class="form-control m-input"
                                          placeholder="Heating Euro"
                                          name="heating_euro"
                                          value="{{ $statistics->heating_eur }}">
                                @if ($errors->has('heating_euro'))
                                    <span class="form-control-feedback">{{$errors->first('heating_euro')}}</span>
                                @else
                                    {{--<span class="form-control-feedback">
                                        Please enter value
                                    </span>--}}
                                @endif
                        </div>

                        <div class="col-lg-6   {{$errors->has('heating_kwh') ? 'has-danger' : ''}}">
                                <label>
                                    Heating kWH:
                                </label>
                                    <input
                                        type="text"
                                        class="form-control m-input"
                                         placeholder="Heating kWH"
                                         name="heating_kwh"
                                         value="{{ $statistics->heating_kwh }}">
                                @if ($errors->has('heating_kwh'))
                                    <span class="form-control-feedback">{{$errors->first('heating_kwh')}}</span>
                                @else
                                    {{--<span class="form-control-feedback">
                                        Please enter value
                                    </span>--}}
                                @endif
                        </div>


                    </div>

                    <div class="form-group required m-form__group row">
                         <div class="col-lg-6 {{$errors->has('water_euro') ? 'has-danger' : ''}}">
                                <label>
                                    Water Euro
                                </label>
                                    <input
                                        type="text"
                                        class="form-control m-input"
                                        placeholder="Water Euro"
                                         name="water_euro"
                                         value="{{ $statistics->water_eur }}">
                                @if ($errors->has('water_euro'))
                                    <span class="form-control-feedback">{{$errors->first('water_euro')}}</span>
                                @else
                                    {{--<span class="form-control-feedback">
                                        Please enter value
                                    </span>--}}
                                @endif
                        </div>

                        <div class="col-lg-6  {{$errors->has('water_litres') ? 'has-danger' : ''}}">
                                <label>
                                    Water Litres
                                </label>
                                    <input
                                        type="text"
                                        class="form-control m-input"
                                        placeholder="Water Litres"
                                        name="water_litres"
                                        value="{{ $statistics->water_litres }}">
                                @if ($errors->has('water_litres'))
                                    <span class="form-control-feedback">{{$errors->first('water_litres')}}</span>
                                @else
                                    {{--<span class="form-control-feedback">
                                        Please enter value
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



