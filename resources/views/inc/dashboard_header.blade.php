<div class="links text-center">
	<a href="{{route('account.create')}}">{{__('dashboard.account')}}</a>
	<a href="">{{__('dashboard.request')}}</a>
	<a href="{{route('groups.create')}}">{{__('dashboard.group')}}</a>
	<a href="{{route('contacts.index')}}">{{__('dashboard.contact')}}</a>
	<a href="#">{{__('dashboard.plan')}}</a>
	<a class="btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
	   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		{{__('dashboard.overview')}}
	</a>
	<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
		<a class="dropdown-item" href="{{route('account.index')}}">{{__('dashboard.accounts')}}</a>
		<a class="dropdown-item" href="#">{{__('dashboard.requests')}}</a>
		<a class="dropdown-item" href="{{route('groups.index')}}">{{__('dashboard.groups')}}</a>
		<a class="dropdown-item" href="{{route('calendar')}}">{{__('dashboard.calendar')}}</a>
	</div>
</div>
<hr>