@extends('avored::layouts.app')

@section('meta_title')
    {{ __('avored::system.currency.edit.title') }}: AvoRed E commerce Admin Dashboard
@endsection

@section('page_title')
    {{ __('avored::system.currency.edit.title') }}
@endsection

@section('content')
<a-row type="flex" justify="center">
    <a-col :span="24">
        <currency-save base-url="{{ asset(config('avored.admin_url')) }}" :currency="{{ $currency }}" inline-template>
        <div>
            <a-form 
                :form="currencyForm"
                method="post"
                action="{{ route('admin.currency.update', $currency->id) }}"                    
                @submit="handleSubmit"
            >
                @csrf
                @method('put')
                @include('avored::system.currency._fields')

                
                <a-form-item>
                    <a-button
                        type="primary"
                        html-type="submit"
                    >
                        {{ __('avored::system.btn.save') }}
                    </a-button>
                    
                    <a-button
                        class="ml-1"
                        type="default"
                        v-on:click.prevent="cancelCurrency"
                    >
                        {{ __('avored::system.btn.cancel') }}
                    </a-button>
                </a-form-item>
            </a-form>
            </div>
        </currency-save>
    </a-col>
</a-row>
@endsection
