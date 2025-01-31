@extends('avored::layouts.app')

@section('meta_title')
    {{ __('avored::catalog.property.edit.title') }}: AvoRed E commerce Admin Dashboard
@endsection

@section('page_title')
    {{ __('avored::catalog.property.edit.title') }}
@endsection

@section('content')
<a-row type="flex" justify="center">
    <a-col :span="24">
        <property-save
            base-url="{{ asset(config('avored.admin_url')) }}"
            :property="{{ $property }}" inline-template>
        <div>
            <a-form 
                :form="propertyForm"
                method="post"
                action="{{ route('admin.property.update', $property->id) }}"                    
                @submit="handleSubmit"
            >
                @csrf
                @method('put')
                @include('avored::catalog.property._fields')
                
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
                        v-on:click.prevent="cancelProperty"
                    >
                        {{ __('avored::system.btn.cancel') }}
                    </a-button>
                </a-form-item>
            </a-form>
            </div>
        </property-save>
    </a-col>
</a-row>
@endsection
