<div class="table-responsive">
    <table class="table table-striped table-hover table-bordered mb-0">
        <tr>
            <th>@lang('Type')</th>
            <td>@include('backend.auth.user.includes.type', ['user' => $logged_in_user])</td>
        </tr>

        <tr>
            <th>@lang('Avatar')</th>
            <td>
                @if($logged_in_user->avatar)
                    <img src="{{ asset('storage/' . $logged_in_user->avatar) }}" alt="{{ $logged_in_user->name }}'s Avatar" style="width: 100px; height: 100px;">
                @else
                    <img src="{{ asset('https://gravatar.com/avatar/') }}" class="user-profile-image" alt="Default Avatar" />
                @endif
            </td>
        </tr>

        <tr>
            <th>@lang('Name')</th>
            <td>{{ $logged_in_user->name }}</td>
        </tr>

        <tr>
            <th>@lang('E-mail Address')</th>
            <td>{{ $logged_in_user->email }}</td>
        </tr>

        @if ($logged_in_user->isSocial())
            <tr>
                <th>@lang('Social Provider')</th>
                <td>{{ ucfirst($logged_in_user->provider) }}</td>
            </tr>
        @endif

        <tr>
            <th>@lang('Timezone')</th>
            <td>{{ $logged_in_user->timezone ? str_replace('_', ' ', $logged_in_user->timezone) : __('N/A') }}</td>
        </tr>

        <tr>
            <th>@lang('Account Created')</th>
            <td>@displayDate($logged_in_user->created_at) ({{ $logged_in_user->created_at->diffForHumans() }})</td>
        </tr>

        <tr>
            <th>@lang('Last Updated')</th>
            <td>@displayDate($logged_in_user->updated_at) ({{ $logged_in_user->updated_at->diffForHumans() }})</td>
        </tr>
    </table>
</div><!--table-responsive-->
