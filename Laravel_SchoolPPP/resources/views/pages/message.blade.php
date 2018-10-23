@extends('common.page_wrapper.index')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="m-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                Send charts to email
                            </h3>
                        </div>
                    </div>
                </div>
                <!--begin::Form-->
                <form method="POST" action="/email" class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
                    {!! csrf_field() !!}
                    <div class="m-portlet__body">
                        <div class="form-group m-form__group row">
                             <div class="col-lg-6  {{$errors->has('school') ? 'has-danger' : ''}}">
                                <label for="exampleSelect1">
                                    School
                                </label>
                                <select class="form-control m-input m-input--square" multiple name="school[]" id="school">
                                    @foreach($schools as $school)
                                        <option value="{{ $school['id'] }}">{{ $school['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- year select --}}

                       <div class="form-group required m-form__group row">
                            <div class="col-lg-6  {{$errors->has('year') ? 'has-danger' : ''}}">
                                <label for="exampleSelect1">
                                    Year
                                </label>
                                <select class="form-control m-input m-input--square" name="year" id="year">
                                    <option value="">
                                        Please select year
                                    </option>
                                    @foreach($years as $year)
                                        <option value="{{ $year }}" @if(date('Y') == $year)selected="selected"@endif>{{ $year }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-6  {{$errors->has('month') ? 'has-danger' : ''}}">
                                <label for="exampleSelect1">
                                    Month
                                </label>
                                <select class="form-control m-input m-input--square" name="month" id="month">
                                    <option value="">
                                        Please select month
                                    </option>
                                    @foreach($months as $id => $month)
                                        <option value="{{ $id }}">{{ $month }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group required m-form__group row">
                            <div class="col-lg-6  {{$errors->has('email') ? 'has-danger' : ''}}">
                                    <label>
                                        Email
                                    </label>
                                        <input 
                                            type="email" 
                                            id="email"
                                            class="form-control m-input" 
                                            placeholder="Enter email" 
                                            name="email"
                                            value="{{ old('email') }}">
                                    @if ($errors->has('email'))
                                        <span class="form-control-feedback">{{$errors->first('email')}}</span>
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
                                    <button type="submit" id="send" class="btn btn-primary">
                                        Send
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!--end::Form-->
            </div>

        </div>
    </div>
@endsection

@section('script_content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.bundle.min.js" ></script>
@endsection