{{--@extends('admin.base')--}}

{{--@section('title', $property->exists ? "Modifier une propriété" : "Configurer un appartement")--}}

{{--@section('content')--}}
{{--    <div id="successMessage"></div>--}}
{{--    <div class="d-flex justify-content-between align-items-center">--}}
{{--        <h1 id="title">@yield('title')</h1>--}}
{{--        <a href="{{ route('immeubles.showAppartement') }}" class="btn btn-secondary">Retour</a>--}}
{{--    </div>--}}

{{--    <hr>--}}

{{--    <form  id="anto" action="{{ $property->exists ? route('admin.property.update', $property->id) : route('admin.property.store') }}" method="POST">--}}
{{--        @csrf--}}
{{--        @if($property->exists)--}}
{{--            @method("PUT")--}}
{{--        @endif--}}
{{--        <div class="row mt-2">--}}


{{--            @include('admin.property.formProperty.propertyForm')--}}
{{--            <input type="hidden" id='codeCli' name="codeCli" value="{{ $codeCli }}">--}}
{{--            <div class="mt-3">--}}

{{--                <button type="button"  id='submitForm' class="btn btn-primary w-25" style="display: none">--}}

{{--                </button>--}}
{{--            </div>--}}
{{--            <h3 class="mt-4">Enregistrement Calorimètre </h3>--}}
{{--            <table class="table" >--}}
{{--                <thead>--}}
{{--                <tr>--}}
{{--                    <th scope="col">N° Série</th>--}}
{{--                    <th scope="col">Type</th>--}}
{{--                    <th scope="col">Status</th>--}}
{{--                    <th scope="col">Situation</th>--}}
{{--                    <th scope="col">Coefficient</th>--}}
{{--                    <th scope="col">Actif</th>--}}
{{--                </tr>--}}
{{--                </thead>--}}
{{--                <tbody id="tbody_cal">--}}
{{--                    <tr id="row_cal" style="display: none;" >--}}
{{--                        <td><input type="text" class="form-control"  id="serialNumber_cal" name="serialNumber_cal" maxlength="8" pattern="[0-9]{8}" ></td>--}}
{{--                        <td><input type="text" class="form-control " id="type_cal" name="type_cal"></td>--}}
{{--                        <td><input type="text" class="form-control " id="status_cal" name="status_cal"></td>--}}
{{--                        <td><input type="text" class="form-control " id="situation_cal" name="situation_cal"></td>--}}
{{--                        <td><input type="text" class="form-control " id="coefficient_cal" name="coefficient_cal"></td>--}}
{{--                        <td>--}}
{{--                            <div class="form-check form-switch">--}}
{{--                                <input class="form-check-input" type="checkbox" role="switch" id="flexSwitch_cal" name="flexSwitch_cal">--}}
{{--                            </div>--}}
{{--                        </td>--}}
{{--                    </tr>--}}
{{--                </tbody>--}}
{{--            </table>--}}
{{--            <h3 class="mt-4">Enregistrement Compteur EC </h3>--}}
{{--            <table class="table" >--}}
{{--                <thead>--}}
{{--                <tr>--}}
{{--                    <th scope="col">N° Série</th>--}}
{{--                    <th scope="col">Type</th>--}}
{{--                    <th scope="col">Status</th>--}}
{{--                    <th scope="col">Situation</th>--}}
{{--                    <th scope="col">Coefficient</th>--}}
{{--                    <th scope="col">Actif</th>--}}
{{--                </tr>--}}
{{--                </thead>--}}
{{--                <tbody id="tbody_cpt_EC">--}}
{{--                    <tr id="row_EC" style="display: none;" >--}}
{{--                        <td><input type="text" class="form-control"  id="serialNumber_EC" name="serialNumber_EC" maxlength="8" pattern="[0-9]{8}" ></td>--}}
{{--                        <td><input type="text" class="form-control " id="type_EC" name="type_EC"></td>--}}
{{--                        <td><input type="text" class="form-control " id="status_EC" name="status_EC"></td>--}}
{{--                        <td><input type="text" class="form-control " id="situation_EC" name="situation_EC"></td>--}}
{{--                        <td><input type="text" class="form-control " id="coefficient_EC" name="coefficient_EC"></td>--}}
{{--                        <td>--}}
{{--                            <div class="form-check form-switch">--}}
{{--                                <input class="form-check-input" type="checkbox" role="switch" id="flexSwitch_EC" name="flexSwitch_EC">--}}
{{--                            </div>--}}
{{--                        </td>--}}
{{--                    </tr>--}}
{{--                </tbody>--}}
{{--            </table>--}}
{{--            <h3 class="mt-4">Enregistrement Compteur EF </h3>--}}
{{--            <table class="table" >--}}
{{--                <thead>--}}
{{--                <tr>--}}
{{--                    <th scope="col">N° Série</th>--}}
{{--                    <th scope="col">Type</th>--}}
{{--                    <th scope="col">Status</th>--}}
{{--                    <th scope="col">Situation</th>--}}
{{--                    <th scope="col">Coefficient</th>--}}
{{--                    <th scope="col">Actif</th>--}}
{{--                </tr>--}}
{{--                </thead>--}}
{{--                <tbody id="tbody_cpt_EF">--}}
{{--                    <tr id="row_EF" style="display: none;" >--}}
{{--                        <td><input type="text" class="form-control"  id="serialNumber_EF" name="serialNumber_EF" maxlength="8" pattern="[0-9]{8}"></td>--}}
{{--                        <td><input type="text" class="form-control " id="type_EF" name="type_EF"></td>--}}
{{--                        <td><input type="text" class="form-control " id="status_EF" name="status_EF"></td>--}}
{{--                        <td><input type="text" class="form-control " id="situation_EF" name="situation_EF"></td>--}}
{{--                        <td><input type="text" class="form-control " id="coefficient_EF" name="coefficient_EF"></td>--}}
{{--                        <td>--}}
{{--                            <div class="form-check form-switch">--}}
{{--                                <input class="form-check-input" type="checkbox" role="switch" id="flexSwitch_EF" name="flexSwitch_EF">--}}
{{--                            </div>--}}
{{--                        </td>--}}
{{--                    </tr>--}}
{{--                </tbody>--}}
{{--            </table>--}}
{{--            <div class="mt-3">--}}

{{--                <button type="submit"  id='submit' class="btn btn-primary w-25" >--}}
{{--                    @if($property->exists)--}}
{{--                        Modifier--}}
{{--                    @else--}}
{{--                        Enregistrer--}}
{{--                    @endif--}}
{{--                </button>--}}
{{--            </div>--}}

{{--        </div>--}}
{{--    </form>--}}
{{--    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>--}}


{{--@endsection--}}

