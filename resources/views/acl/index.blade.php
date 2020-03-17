@extends('layouts.main')

@section('title')
    Права доступа и роли
@endsection

@section('head')
    @parent
@endsection

@section('content')

    <div id="addRoleModal" class="modal" style="width: 40%">
        <form action="{{ route('acl.storeRole') }}" method="POST" id="addRoleForm">
            @csrf
            <div class="modal-content">
                <h5>Создать роль</h5>
                    
                    <div class="container">
                        <div class="row">
                            <div class="input-field col s12">
                                <i class="material-icons prefix">perm_identity</i>
                                <input id="name" name="name" type="text" required>
                                <label for="name">Название в БД</label>
                            </div>

                            <div class="input-field col s12">
                                <i class="material-icons prefix">perm_identity</i>
                                <input id="display_name" name="display_name" type="text">
                                <label for="display_name">Название для пользователя</label>
                            </div>

                            <div class="input-field col s12">
                                <i class="material-icons prefix">perm_identity</i>
                                <input id="description" name="description" type="text">
                                <label for="description">Описание</label>
                            </div>
                        </div>
                    </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="waves-effect waves-light btn green">
                    <span>Создать</span>
                </button>
            </div>
        </form>
    </div>
    
    <div id="addPermissionModal" class="modal" style="width: 40%">
        <form action="{{ route('acl.storePermission') }}" method="POST" id="addPermissionForm">
            @csrf
            <div class="modal-content">
                <h5>Создать право доступа</h5>
                    
                    <div class="container">
                        <div class="row">
                            <div class="input-field col s12">
                                <i class="material-icons prefix">perm_identity</i>
                                <input id="name" name="name" type="text" required>
                                <label for="name">Название в БД</label>
                            </div>

                            <div class="input-field col s12">
                                <i class="material-icons prefix">perm_identity</i>
                                <input id="display_name" name="display_name" type="text">
                                <label for="display_name">Название для пользователя</label>
                            </div>

                            <div class="input-field col s12">
                                <i class="material-icons prefix">perm_identity</i>
                                <input id="description" name="description" type="text">
                                <label for="description">Описание</label>
                            </div>
                        </div>
                    </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="waves-effect waves-light btn green">
                    <span>Создать</span>
                </button>
            </div>
        </form>
    </div>

    <div class="breadcrumbs-dark pb-0 pt-4" id="breadcrumbs-wrapper">
        <div class="container">
            <div class="row">
                <div class="col s10 m6 l6">
                    <h5 class="breadcrumbs-title mt-0 mb-0"><span>Права доступа и роли</span></h5>
                    <ol class="breadcrumbs mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Главная</a></li>
                        <li class="breadcrumb-item active">Права доступа и роли</li>
                    </ol>
                </div>

                <div class="col s2 m6 l6">
                    <a 
                        onclick="event.preventDefault(); document.getElementById('setAclForm').submit();"
                        class="btn waves-effect waves-light breadcrumbs-btn right green mr-2" href="#">
                        <i class="material-icons hide-on-med-and-up">add</i>
                        <span class="hide-on-small-onl">Сохранить</span>
                    </a>
                    <a class="btn waves-effect waves-light breadcrumbs-btn right green mr-2 modal-trigger" href="#addRoleModal">
                        <i class="material-icons hide-on-med-and-up">add</i>
                        <span class="hide-on-small-onl">Создать роль</span>
                    </a>
                    <a class="btn waves-effect waves-light breadcrumbs-btn right blue mr-2 modal-trigger" href="#addPermissionModal">
                        <i class="material-icons hide-on-med-and-up">add</i>
                        <span class="hide-on-small-onl">Создать право доступа</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col s12 m12 l12">
            <form action="{{ route('acl.set') }}" method="POST" id="setAclForm">
                @csrf
                <div class="card">
                    <div class="card-tabs">
                        <ul class="tabs tabs-fixed-width">
                            @foreach ($roles as $idx => $role)
                                <li class="tab"><a href="#role{{ $role->id }}" class="{{ $idx === 0 ? 'active' : null }}">{{ $role->display_name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="card-content grey lighten-4">
                        @foreach ($roles as $idx => $role)
                            <div id="role{{ $role->id }}" style="display: block;" class="{{ $idx === 0 ? 'active' : null }}">
                                <ul class="collection mb-0">
                                    @foreach ($permissions as $idx => $permission)
                                        <li class="collection-item">
                                            <label class="checkbox-label">
                                                <input
                                                    name="acl[{{ $role['id'] }}][permissions][{{ $permission['id'] }}]"
                                                    value="{{ $permission->id }}"
                                                    type="checkbox" 
                                                    {{ in_array($permission->id, $role->permissions()->pluck('id')->toArray()) ? 'checked' : null }}
                                                />
                                                <span>{{ $permission->display_name }}</span>
                                            </label>
                                        </li>                                    
                                    @endforeach
                                </ul> 
                            </div>
                        @endforeach
                    </div>
                    <div class="card-action">
                        <button type="submit" style="float: right" class="waves-effect waves-light btn green">Сохранить</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    @parent

    <script src="{{ asset('assets/js/scripts/advance-ui-modals.min.js') }}"></script>
@endsection