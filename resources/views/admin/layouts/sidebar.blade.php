<div class="navbar-bg"></div>
{{-- Navbar Start --}}
@include('admin.layouts.navbar')
{{-- Nvabar End --}}
<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">{{ __('admin.Stisla') }}</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">{{ __('admin.St') }}</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">{{ __('admin.Dashboard') }}</li>
            <li class=" active">
                <a href="{{ route('admin.dashboard') }}" class="nav-link"><i
                        class="fas fa-fire"></i><span>{{ __('admin.Dashboard') }}</span></a>

            </li>
            <li class="menu-header">{{ __('admin.Starter') }}</li>

            @if (canAccess(['category index', 'category create', 'category update', 'category delete']))
                <li class="@sidebarActive(['admin.category.*'])"><a class="nav-link" href="{{ route('admin.category.index') }}"><i
                            class="fas fa-list"></i>
                        <span>{{ __('admin.Category') }}</span></a></li>
            @endif

            @if (canAccess('news index'))
                <li class="dropdown @sidebarActive(['admin.news.*', 'admin.pending.news'])">
                    <a href="#" class="nav-link has-dropdown"><i class="far fa-newspaper"></i>
                        <span>{{ __('admin.News') }}</span></a>
                    <ul class="dropdown-menu">
                        <li class="@sidebarActive(['admin.news.*'])"><a class="nav-link"
                                href="{{ route('admin.news.index') }}">{{ __('admin.All News') }}</a></li>
                        <li class="@sidebarActive(['admin.pending.news'])"><a class="nav-link"
                                href="{{ route('admin.pending.news') }}">{{ __('admin.Pending News') }}</a></li>
                        {{-- <li><a class="nav-link" href="forms-validation.html">{{ __('admin.Validation') }}</a></li> --}}
                    </ul>
                </li>
            @endif

            @if (canAccess(['about index', 'contact index']))
                <li class="dropdown @sidebarActive(['admin.about.*', 'admin.contact.*'])">
                    <a href="#" class="nav-link has-dropdown"><i class="far fa-file-alt"></i>
                        <span>{{ __('admin.Pages') }}</span></a>
                    <ul class="dropdown-menu">
                        @if (canAccess('about index'))
                            <li class="@sidebarActive(['admin.about.*'])"><a class="nav-link"
                                    href="{{ route('admin.about.index') }}">{{ __('admin.About Page') }}</a></li>
                        @endif
                        @if (canAccess('contact index'))
                            <li class="@sidebarActive(['admin.contact.*'])"><a class="nav-link"
                                    href="{{ route('admin.contact.index') }}">{{ __('admin.Contact Page') }}</a></li>
                        @endif
                    </ul>
                </li>
            @endif

            @if (canAccess('social count index'))
                <li class="@sidebarActive(['admin.social-count.*'])"><a class="nav-link" href="{{ route('admin.social-count.index') }}"><i
                            class="fas fa-hashtag"></i>
                        <span>{{ __('admin.Social Count') }}</span></a></li>
            @endif

            @if (canAccess('contact message index'))
                <li class="@sidebarActive(['admin.contact-message.*'])"><a class="nav-link" href="{{ route('admin.contact-message.index') }}"><i
                            class="fas fa-id-card-alt"></i>
                        <span>{{ __('admin.Contact Messages') }}</span>
                        @if ($unReadMessages > 0)
                            <i
                                class="badge bg-success beep beep-sidebar"style="color: #fff; margin: auto">{{ $unReadMessages }}</i>
                        @endif
                    </a></li>
            @endif

            @if (canAccess('home section index'))
                <li class="@sidebarActive(['admin.home-section-setting.*'])"><a class="nav-link"
                        href="{{ route('admin.home-section-setting.index') }}"><i class="fas fa-wrench"></i>
                        <span>{{ __('admin.Home Section Setting') }}</span></a></li>
            @endif

            @if (canAccess('advertisement index'))
                <li class="@sidebarActive(['admin.ad.*'])"><a class="nav-link" href="{{ route('admin.ad.index') }}"><i
                            class="fas fa-ad"></i>
                        <span>{{ __('admin.Advertisement') }}</span></a></li>
            @endif

            @if (canAccess('subscribers index'))
                <li class="@sidebarActive(['admin.subscribers.*'])"><a class="nav-link" href="{{ route('admin.subscribers.index') }}"><i
                            class="fas fa-users"></i>
                        <span>{{ __('admin.Subscribers') }}</span></a></li>
            @endif

            @if (canAccess('footer index'))
                <li class="dropdown @sidebarActive(['admin.social-link.*', 'admin.footer-info.*', 'admin.footer-grid-one.*', 'admin.footer-grid-two.*', 'admin.footer-grid-three.*'])">
                    <a href="#" class="nav-link has-dropdown"><i class="far fa-file-alt"></i>
                        <span>{{ __('admin.Footer Setting') }}</span></a>
                    <ul class="dropdown-menu">
                        <li class="@sidebarActive(['admin.social-link.*'])"><a class="nav-link"
                                href="{{ route('admin.social-link.index') }}">{{ __('admin.Social Links') }}</a></li>
                        <li class="@sidebarActive(['admin.footer-info.*'])"><a class="nav-link"
                                href="{{ route('admin.footer-info.index') }}">{{ __('admin.Footer Info') }}</a></li>
                        <li class="@sidebarActive(['admin.footer-grid-one.*'])"><a class="nav-link"
                                href="{{ route('admin.footer-grid-one.index') }}">{{ __('admin.Footer Grid One') }}</a>
                        </li>
                        <li class="@sidebarActive(['admin.footer-grid-two.*'])"><a class="nav-link"
                                href="{{ route('admin.footer-grid-two.index') }}">{{ __('admin.Footer Grid Two') }}</a>
                        </li>
                        <li class="@sidebarActive(['admin.footer-grid-three.*'])"><a class="nav-link"
                                href="{{ route('admin.footer-grid-three.index') }}">{{ __('admin.Footer Grid Three') }}</a>
                        </li>
                    </ul>
                </li>
            @endif

            @if (canAccess('access management index'))
                <li class="dropdown @sidebarActive(['admin.role-users.*', 'admin.role.*'])">
                    <a href="#" class="nav-link has-dropdown"><i class="fas fa-user-shield"></i>
                        <span>{{ __('admin.Access Management') }}</span></a>
                    <ul class="dropdown-menu">
                        <li class="@sidebarActive(['admin.role-users.*'])"><a class="nav-link"
                                href="{{ route('admin.role-users.index') }}">
                                <span>{{ __('admin.Role Users') }}</span></a></li>
                        <li class="@sidebarActive(['admin.role.*'])"><a class="nav-link" href="{{ route('admin.role.index') }}">
                                <span>{{ __('admin.Roles and Permissions') }}</span></a></li>
                    </ul>
                </li>
            @endif

            @if (canAccess('setting index'))
                <li class="@sidebarActive(['admin.setting.*'])"><a class="nav-link" href="{{ route('admin.setting.index') }}"><i
                            class="fas fa-cog"></i>
                        <span>{{ __('admin.Settings') }}</span></a></li>
            @endif

            @if (canAccess('languages index'))
                <li class="dropdown @sidebarActive(['admin.language.*', 'admin.frontend-localization.*', 'admin.admin-localization.*'])">
                    <a href="#" class="nav-link has-dropdown"><i class="fas fa-language"></i>
                        <span>{{ __('admin.Localization') }}</span></a>
                    <ul class="dropdown-menu">
                        <li class="@sidebarActive(['admin.language.*'])"><a class="nav-link"
                                href="{{ route('admin.language.index') }}">
                                <span>{{ __('admin.Languages') }}</span></a></li>
                        <li class="@sidebarActive(['admin.frontend-localization.index'])"><a class="nav-link"
                                href="{{ route('admin.frontend-localization.index') }}">
                                <span>{{ __('admin.Frontend Lang') }}</span></a></li>

                        <li class="@sidebarActive(['admin.admin-localization.index'])"><a class="nav-link"
                                href="{{ route('admin.admin-localization.index') }}">
                                <span>{{ __('admin.Admin Lang') }}</span></a></li>
                    </ul>
                </li>
            @endif
            {{-- <li><a class="nav-link" href="blank.html"><i class="far fa-square"></i> <span>Blank Page</span></a></li> --}}

            {{-- <li class="dropdown">
        <a href="#" class="nav-link has-dropdown"><i class="far fa-file-alt"></i> <span>Forms</span></a>
        <ul class="dropdown-menu">
          <li><a class="nav-link" href="forms-advanced-form.html">Advanced Form</a></li>
          <li><a class="nav-link" href="forms-editor.html">Editor</a></li>
          <li><a class="nav-link" href="forms-validation.html">Validation</a></li>
        </ul>
      </li> --}}


        </ul>
    </aside>
</div>
