@php
    $user = auth()->user();
@endphp
<div class="col-xl-3">
    <div class="dashboard-menu">
        <div class="user">
            <span class="side-sidebar-close-btn"><i class="las la-times"></i></span>
            <div class="thumb">
                <a href="{{ route('user.profile.setting') }}">
                    <img id="user-image"
                        src="{{ getImage(getFilePath('user') . '/' . $user->image, getFileSize('user')) }}"
                        alt="user">
                </a>
            </div>
            <div class="content">
                <h6 class="title"><a href="{{ route('user.profile.setting') }}"><span>@</span>{{ $user->username }}</a>
                </h6>
            </div>
        </div>
        <ul>
            <li>
                <a href="{{ route('user.home') }}" class="{{ menuActive('user.home') }}"><i
                        class="las la-home"></i>@lang('Dashboard') </a>
            </li>

            <li>
                <a href="{{ route('user.currency.all') }}"
                    class="{{ menuActive(['user.currency.all', 'user.currency.single']) }}"><i class="las la-coins"></i>
                    @lang('Crypto Currency')</a>
            </li>
            <li>
                <a href="{{ route('user.wallet.all') }}"
                    class="{{ menuActive(['user.wallet.all', 'user.wallet.single']) }}"><i class="la la-wallet"></i>
                    @lang('Wallets')
                </a>
            </li>
            <li class="sidebar-menu-list__item has-dropdown {{ menuActive('user.deposit.*') }}">
                <a href="javascript:void(0)" class="sidebar-menu-list__link">
                    <span class="icon"><i class="las la-wallet"></i></span>
                    <span class="text">@lang('Deposit')</span>
                </a>
                <div class="sidebar-submenu">
                    <ul class="sidebar-submenu-list">
                        <li class="sidebar-submenu-list__item {{ menuActive('user.deposit.index') }}">
                            <a href="{{ route('user.deposit.index') }}" class="sidebar-submenu-list__link">
                                <span class="icon"><i class="las la-dot-circle"></i></span>
                                <span class="text">@lang('Deposit Now')</span>
                            </a>
                        </li>
                        <li class="sidebar-submenu-list__item {{ menuActive('user.deposit.history') }}">
                            <a href="{{ route('user.deposit.history') }}" class="sidebar-submenu-list__link">
                                <span class="icon"><i class="las la-dot-circle"></i></span>
                                <span class="text">@lang('Deposit History')</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="sidebar-menu-list__item has-dropdown {{ menuActive('user.withdraw*') }}">
                <a href="javascript:void(0)" class="sidebar-menu-list__link">
                    <span class="icon"><i class="las la-hand-holding-usd"></i></span>
                    <span class="text">@lang('Withdraw')</span>
                </a>
                <div class="sidebar-submenu">
                    <ul class="sidebar-submenu-list">
                        <li class="sidebar-submenu-list__item {{ menuActive('user.withdraw') }}">
                            <a href="{{ route('user.withdraw') }}" class="sidebar-submenu-list__link">
                                <span class="icon"><i class="las la-dot-circle"></i></span>
                                <span class="text">@lang('Withdraw Now')</span>
                            </a>
                        </li>
                        <li class="sidebar-submenu-list__item {{ menuActive('user.withdraw.history') }}">
                            <a href="{{ route('user.withdraw.history') }}" class="sidebar-submenu-list__link">
                                <span class="icon"><i class="las la-dot-circle"></i></span>
                                <span class="text">@lang('Withdraw History')</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="sidebar-menu-list__item has-dropdown {{ menuActive('ticket.*') }}">
                <a href="javascript:void(0)" class="sidebar-menu-list__link">
                    <span class="icon"><i class="las la-ticket-alt"></i></span>
                    <span class="text">@lang('Support Ticket')</span>
                </a>
                <div class="sidebar-submenu">
                    <ul class="sidebar-submenu-list">
                        <li class="sidebar-submenu-list__item {{ menuActive('ticket.open') }}">
                            <a href="{{ route('ticket.open') }}" class="sidebar-submenu-list__link">
                                <span class="icon"><i class="las la-dot-circle"></i></span>
                                <span class="text">@lang('Create Ticket')</span>
                            </a>
                        </li>
                        <li class="sidebar-submenu-list__item {{ menuActive('ticket.index') }}">
                            <a href="{{ route('ticket.index') }}" class="sidebar-submenu-list__link">
                                <span class="icon"><i class="las la-dot-circle"></i></span>
                                <span class="text">@lang('My Tickets')</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li>
                <a href="{{ route('user.transactions') }}" class="{{ menuActive('user.transactions') }}"><i
                        class="la la-list"></i> @lang('Transaction') </a>
            </li>
            <li>
                <a href="{{ route('user.profile.setting') }}" class="{{ menuActive('user.profile.setting') }}">
                    <i class="las la-user-circle"></i> @lang('Profile Setting')
                </a>
            </li>
            <li>
                <a href="{{ route('user.change.password') }}" class="{{ menuActive('user.change.password') }}">
                    <i class="las la-key"></i> @lang('Change Passoword')
                </a>
            </li>
            <li>
                <a href="{{ route('user.twofactor') }}" class="{{ menuActive('user.twofactor') }}">
                    <i class="las la-unlock"></i> @lang('2FA Security')
                </a>
            </li>
            <li>
                <a href="{{ route('user.logout') }}"><i class="las la-sign-out-alt"></i> @lang('Logout') </a>
            </li>
        </ul>
    </div>
</div>
