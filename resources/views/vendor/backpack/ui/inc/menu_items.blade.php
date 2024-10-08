{{-- This file is used for menu items by any Backpack v6 theme --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>
<x-backpack::menu-item title="Candidates" icon="la la-group" :link="backpack_url('candidate')" />
{{-- <x-backpack::menu-item title="User" icon="la la-key" :link="backpack_url('user')" /> --}}
{{-- <x-backpack::menu-item title="Roles" icon="la la-group" :link="backpack_url('role')" />
<x-backpack::menu-item title="Permissions" icon="la la-key" :link="backpack_url('permission')" /> --}}
<x-backpack::menu-item title="Voters" icon="la la-group" :link="backpack_url('voter')" />
{{-- <x-backpack::menu-item title="Categories" icon="la la-question" :link="backpack_url('category')" /> --}}