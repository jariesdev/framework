@extends('avored::layouts.app')

@section('meta_title')
    {{ __('avored::order.order-status.edit.title') }}: AvoRed E commerce Admin Dashboard
@endsection

@section('page_title')
    {{ __('avored::order.order-status.edit.title') }}
@endsection

@section('content')
<a-row type="flex" justify="center">
    <a-col :span="24">
        <order-status-save
            base-url="{{ asset(config('avored.admin_url')) }}"
            :order-status="{{ $orderStatus }}" inline-template>
        <div>
            <a-form 
                :form="orderStatusForm"
                method="post"
                action="{{ route('admin.order-status.update', $orderStatus->id) }}"                    
                @submit="handleSubmit"
            >
                @csrf
                @method('put')
                @include('avored::order.order-status._fields')
                
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
                        v-on:click.prevent="cancelOrderStatus"
                    >
                        {{ __('avored::system.btn.cancel') }}
                    </a-button>
                </a-form-item>
            </a-form>
            </div>
        </order-status-save>
    </a-col>
</a-row>
@endsection
