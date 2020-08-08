@extends('layout')
@section('componentes_vue')
<v-main>
    <v-container fluid fill-height class="pa-0 " style="max-width:100%" >
        <v-layout>
            <v-fade-transition fluid fill-height mode="out-in">
              <user-pay-order-component></user-pay-order-component>
            </v-fade-transition>
        </v-layout>
    </v-container>
</v-main>
    @include('tema-principal.bar')
    @include('user.user-menu')
@endsection