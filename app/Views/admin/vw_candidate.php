
<?= view('layoutAdmin/header.php'); ?>
        <?= view('layoutAdmin/sidebar.php'); ?>
        <?= view('layoutAdmin/navbar.php'); ?>
    </div>

  

        <div class="pxp-dashboard-content">
            <div class="pxp-dashboard-content-header">
                <div class="pxp-nav-trigger navbar pxp-is-dashboard d-lg-none">
                    <a role="button" data-bs-toggle="offcanvas" data-bs-target="#pxpMobileNav" aria-controls="pxpMobileNav">
                        <div class="pxp-line-1"></div>
                        <div class="pxp-line-2"></div>
                        <div class="pxp-line-3"></div>
                    </a>
                    <div class="offcanvas offcanvas-start pxp-nav-mobile-container pxp-is-dashboard" tabindex="-1" id="pxpMobileNav">
                        <div class="offcanvas-header">
                            <div class="pxp-logo">
                                <a href="index.html" class="pxp-animate"><span style="color: var(--pxpMainColor)">A</span>NP</a>
                            </div>
                            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body">
                            <nav class="pxp-nav-mobile">
                                <ul class="navbar-nav justify-content-end flex-grow-1">
                                    <li class="pxp-dropdown-header">Admin tools</li>
                                    <li class="nav-item"><a href="<?= base_url('admin/dashboard') ?>"><span class="fa fa-home"></span>Dashboard</a></li>
                                    <li class="nav-item"><a href="<?= base_url('admin/profile') ?>"><span class="fa fa-pencil"></span>Edit Profile</a></li>
                                    <li class="nav-item"><a href="<?= base_url('admin/newjobs') ?>"><span class="fa fa-file-text-o"></span>New Job Offer</a></li>
                                    <li class="nav-item"><a href="<?= base_url('admin/managejobs') ?>"><span class="fa fa-briefcase"></span>Manage Jobs</a></li>
                                    <li class="nav-item"><a href="<?= base_url('admin/candidate') ?>"><span class="fa fa-user-circle-o"></span>Candidates</a></li>
                                    <li class="nav-item"><a href="<?= base_url('admin/changepw') ?>"><span class="fa fa-lock"></span>Change Password</a></li>
                                    <li class="pxp-dropdown-header mt-4">Insights</li>
                                    <li class="nav-item">
                                        <a href="company-dashboard-inbox.html" class="d-flex justify-content-between align-items-center">
                                            <div><span class="fa fa-envelope-o"></span>Inbox</div>
                                            <span class="badge rounded-pill">14</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="company-dashboard-notifications.html" class="d-flex justify-content-between align-items-center">
                                            <div><span class="fa fa-bell-o"></span>Notifications</div>
                                            <span class="badge rounded-pill">5</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
                <nav class="pxp-user-nav pxp-on-light">
                    <a href="company-dashboard-new-job.html" class="btn rounded-pill pxp-nav-btn">Post a Job</a>
                    <div class="dropdown pxp-user-nav-dropdown pxp-user-notifications">
                        <a role="button" class="dropdown-toggle" data-bs-toggle="dropdown">
                            <span class="fa fa-bell-o"></span>
                            <div class="pxp-user-notifications-counter">5</div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="company-dashboard-notifications.html"><strong>Scott Goodwin</strong> applied for <strong>Software Engineer</strong>. <span class="pxp-is-time">20m</span></a></li>
                            <li><a class="dropdown-item" href="company-dashboard-notifications.html"><strong>Alayna Becker</strong> sent you a message. <span class="pxp-is-time">1h</span></a></li>
                            <li><a class="dropdown-item" href="company-dashboard-notifications.html"><strong>Erika Tillman</strong> applied for <strong>Team Leader</strong>. <span class="pxp-is-time">2h</span></a></li>
                            <li><a class="dropdown-item" href="company-dashboard-notifications.html"><strong>Scott Goodwin</strong> applied for <strong>Software Engineer</strong>. <span class="pxp-is-time">5h</span></a></li>
                            <li><a class="dropdown-item" href="company-dashboard-notifications.html"><strong>Alayna Becker</strong> sent you a message. <span class="pxp-is-time">1d</span></a></li>
                            <li><a class="dropdown-item" href="company-dashboard-notifications.html"><strong>Erika Tillman</strong> applied for <strong>Software Engineer</strong>. <span class="pxp-is-time">3d</span></a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item pxp-link" href="company-dashboard-notifications.html">Read All</a></li>
                        </ul>
                    </div>
                    <div class="dropdown pxp-user-nav-dropdown">
                        <a role="button" class="dropdown-toggle" data-bs-toggle="dropdown">
                            <div class="pxp-user-nav-avatar pxp-cover" style="background-image: url(images/company-logo-1.png);"></div>
                            <div class="pxp-user-nav-name d-none d-md-block">Artistre Studio</div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="company-dashboard.html">Dashboard</a></li>
                            <li><a class="dropdown-item" href="company-dashboard-profile.html">Edit profile</a></li>
                            <li><a class="dropdown-item" href="index.html">Logout</a></li>
                        </ul>
                    </div>
                </nav>
            </div>

            <div class="pxp-dashboard-content-details">
                <h1>Candidates</h1>
                <p class="pxp-text-light">Detailed list of candidates that applied for your job offers.</p>

                <div class="mt-4 mt-lg-5">
                    <div class="row justify-content-between align-content-center">
                        <div class="col-auto order-2 order-sm-1">
                            <div class="pxp-company-dashboard-jobs-bulk-actions mb-3">
                                <select class="form-select">
                                    <option>Bulk actions</option>
                                    <option>Approve</option>
                                    <option>Reject</option>
                                    <option>Delete</option>
                                </select>
                                <button class="btn ms-2">Apply</button>
                            </div>
                        </div>
                        <div class="col-auto order-1 order-sm-2">
                            <div class="pxp-company-dashboard-jobs-search mb-3">
                                <div class="pxp-company-dashboard-jobs-search-results me-3">16 candidates</div>
                                <div class="pxp-company-dashboard-jobs-search-search-form">
                                    <div class="input-group">
                                        <span class="input-group-text"><span class="fa fa-search"></span></span>
                                        <input type="text" class="form-control" placeholder="Search candidates...">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th class="pxp-is-checkbox" style="width: 1%;"><input type="checkbox" class="form-check-input"></th>
                                    <th colspan="2" style="width: 25%;">Name</th>
                                    <th style="width: 20%;">Applied for</th>
                                    <th style="width: 15%;">Status</th>
                                    <th>Date<span class="fa fa-angle-up ms-3"></span></th>
                                    <th>&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input type="checkbox" class="form-check-input"></td>
                                    <td style="width: 3%;">
                                        <div class="pxp-company-dashboard-candidate-avatar pxp-cover" style="background-image: url(images/ph-small.jpg);"></div>
                                    </td>
                                    <td>
                                        <a href="#">
                                            <div class="pxp-company-dashboard-job-title">Scott Goodwin</div>
                                            <div class="pxp-company-dashboard-job-location"><span class="fa fa-globe me-1"></span>San Francisco, CA</div>
                                        </a>
                                    </td>
                                    <td><div class="pxp-company-dashboard-job-category">Software Developer</div></td>
                                    <td><div class="pxp-company-dashboard-job-status"><span class="badge rounded-pill bg-success">Approved</span></div></td>
                                    <td>
                                        <div class="pxp-company-dashboard-job-date">2020/08/24 at 11:56 am</div>
                                    </td>
                                    <td>
                                        <div class="pxp-dashboard-table-options">
                                            <ul class="list-unstyled">
                                                <li><button title="View profile"><span class="fa fa-eye"></span></button></li>
                                                <li><button title="Send message"><span class="fa fa-envelope-o"></span></button></li>
                                                <li><button title="Approve"><span class="fa fa-check"></span></button></li>
                                                <li><button title="Reject"><span class="fa fa-ban"></span></button></li>
                                                <li><button title="Delete"><span class="fa fa-trash-o"></span></button></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" class="form-check-input"></td>
                                    <td style="width: 3%;">
                                        <div class="pxp-company-dashboard-candidate-avatar pxp-cover" style="background-image: url(images/ph-small.jpg);"></div>
                                    </td>
                                    <td>
                                        <a href="#">
                                            <div class="pxp-company-dashboard-job-title">Kenneth Spiers</div>
                                            <div class="pxp-company-dashboard-job-location"><span class="fa fa-globe me-1"></span>London, UK</div>
                                        </a>
                                    </td>
                                    <td><div class="pxp-company-dashboard-job-category">Marketing Expert</div></td>
                                    <td><div class="pxp-company-dashboard-job-status"><span class="badge rounded-pill bg-danger">Rejected</span></div></td>
                                    <td>
                                        <div class="pxp-company-dashboard-job-date">2020/08/24 at 11:56 am</div>
                                    </td>
                                    <td>
                                        <div class="pxp-dashboard-table-options">
                                            <ul class="list-unstyled">
                                                <li><button title="View profile"><span class="fa fa-eye"></span></button></li>
                                                <li><button title="Send message"><span class="fa fa-envelope-o"></span></button></li>
                                                <li><button title="Approve"><span class="fa fa-check"></span></button></li>
                                                <li><button title="Reject"><span class="fa fa-ban"></span></button></li>
                                                <li><button title="Delete"><span class="fa fa-trash-o"></span></button></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" class="form-check-input"></td>
                                    <td style="width: 3%;">
                                        <div class="pxp-company-dashboard-candidate-avatar pxp-cover" style="background-image: url(images/ph-small.jpg);"></div>
                                    </td>
                                    <td>
                                        <a href="#">
                                            <div class="pxp-company-dashboard-job-title">Rebecca Eason</div>
                                            <div class="pxp-company-dashboard-job-location"><span class="fa fa-globe me-1"></span>Paris, France</div>
                                        </a>
                                    </td>
                                    <td><div class="pxp-company-dashboard-job-category">Architect</div></td>
                                    <td><div class="pxp-company-dashboard-job-status"><span class="badge rounded-pill bg-secondary">N/A</span></div></td>
                                    <td>
                                        <div class="pxp-company-dashboard-job-date">2020/08/24 at 11:56 am</div>
                                    </td>
                                    <td>
                                        <div class="pxp-dashboard-table-options">
                                            <ul class="list-unstyled">
                                                <li><button title="View profile"><span class="fa fa-eye"></span></button></li>
                                                <li><button title="Send message"><span class="fa fa-envelope-o"></span></button></li>
                                                <li><button title="Approve"><span class="fa fa-check"></span></button></li>
                                                <li><button title="Reject"><span class="fa fa-ban"></span></button></li>
                                                <li><button title="Delete"><span class="fa fa-trash-o"></span></button></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" class="form-check-input"></td>
                                    <td style="width: 3%;">
                                        <div class="pxp-company-dashboard-candidate-avatar pxp-cover" style="background-image: url(images/ph-small.jpg);"></div>
                                    </td>
                                    <td>
                                        <a href="#">
                                            <div class="pxp-company-dashboard-job-title">Susanne Weil</div>
                                            <div class="pxp-company-dashboard-job-location"><span class="fa fa-globe me-1"></span>Los Angeles, CA</div>
                                        </a>
                                    </td>
                                    <td><div class="pxp-company-dashboard-job-category">UI Designer</div></td>
                                    <td><div class="pxp-company-dashboard-job-status"><span class="badge rounded-pill bg-success">Approved</span></div></td>
                                    <td>
                                        <div class="pxp-company-dashboard-job-date">2020/08/24 at 11:56 am</div>
                                    </td>
                                    <td>
                                        <div class="pxp-dashboard-table-options">
                                            <ul class="list-unstyled">
                                                <li><button title="View profile"><span class="fa fa-eye"></span></button></li>
                                                <li><button title="Send message"><span class="fa fa-envelope-o"></span></button></li>
                                                <li><button title="Approve"><span class="fa fa-check"></span></button></li>
                                                <li><button title="Reject"><span class="fa fa-ban"></span></button></li>
                                                <li><button title="Delete"><span class="fa fa-trash-o"></span></button></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" class="form-check-input"></td>
                                    <td style="width: 3%;">
                                        <div class="pxp-company-dashboard-candidate-avatar pxp-cover" style="background-image: url(images/ph-small.jpg);"></div>
                                    </td>
                                    <td>
                                        <a href="#">
                                            <div class="pxp-company-dashboard-job-title">Scott Goodwin</div>
                                            <div class="pxp-company-dashboard-job-location"><span class="fa fa-globe me-1"></span>San Francisco, CA</div>
                                        </a>
                                    </td>
                                    <td><div class="pxp-company-dashboard-job-category">Software Developer</div></td>
                                    <td><div class="pxp-company-dashboard-job-status"><span class="badge rounded-pill bg-success">Approved</span></div></td>
                                    <td>
                                        <div class="pxp-company-dashboard-job-date">2020/08/24 at 11:56 am</div>
                                    </td>
                                    <td>
                                        <div class="pxp-dashboard-table-options">
                                            <ul class="list-unstyled">
                                                <li><button title="View profile"><span class="fa fa-eye"></span></button></li>
                                                <li><button title="Send message"><span class="fa fa-envelope-o"></span></button></li>
                                                <li><button title="Approve"><span class="fa fa-check"></span></button></li>
                                                <li><button title="Reject"><span class="fa fa-ban"></span></button></li>
                                                <li><button title="Delete"><span class="fa fa-trash-o"></span></button></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" class="form-check-input"></td>
                                    <td style="width: 3%;">
                                        <div class="pxp-company-dashboard-candidate-avatar pxp-cover" style="background-image: url(images/ph-small.jpg);"></div>
                                    </td>
                                    <td>
                                        <a href="#">
                                            <div class="pxp-company-dashboard-job-title">Kenneth Spiers</div>
                                            <div class="pxp-company-dashboard-job-location"><span class="fa fa-globe me-1"></span>London, UK</div>
                                        </a>
                                    </td>
                                    <td><div class="pxp-company-dashboard-job-category">Marketing Expert</div></td>
                                    <td><div class="pxp-company-dashboard-job-status"><span class="badge rounded-pill bg-danger">Rejected</span></div></td>
                                    <td>
                                        <div class="pxp-company-dashboard-job-date">2020/08/24 at 11:56 am</div>
                                    </td>
                                    <td>
                                        <div class="pxp-dashboard-table-options">
                                            <ul class="list-unstyled">
                                                <li><button title="View profile"><span class="fa fa-eye"></span></button></li>
                                                <li><button title="Send message"><span class="fa fa-envelope-o"></span></button></li>
                                                <li><button title="Approve"><span class="fa fa-check"></span></button></li>
                                                <li><button title="Reject"><span class="fa fa-ban"></span></button></li>
                                                <li><button title="Delete"><span class="fa fa-trash-o"></span></button></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" class="form-check-input"></td>
                                    <td style="width: 3%;">
                                        <div class="pxp-company-dashboard-candidate-avatar pxp-cover" style="background-image: url(images/ph-small.jpg);"></div>
                                    </td>
                                    <td>
                                        <a href="#">
                                            <div class="pxp-company-dashboard-job-title">Rebecca Eason</div>
                                            <div class="pxp-company-dashboard-job-location"><span class="fa fa-globe me-1"></span>Paris, France</div>
                                        </a>
                                    </td>
                                    <td><div class="pxp-company-dashboard-job-category">Architect</div></td>
                                    <td><div class="pxp-company-dashboard-job-status"><span class="badge rounded-pill bg-secondary">N/A</span></div></td>
                                    <td>
                                        <div class="pxp-company-dashboard-job-date">2020/08/24 at 11:56 am</div>
                                    </td>
                                    <td>
                                        <div class="pxp-dashboard-table-options">
                                            <ul class="list-unstyled">
                                                <li><button title="View profile"><span class="fa fa-eye"></span></button></li>
                                                <li><button title="Send message"><span class="fa fa-envelope-o"></span></button></li>
                                                <li><button title="Approve"><span class="fa fa-check"></span></button></li>
                                                <li><button title="Reject"><span class="fa fa-ban"></span></button></li>
                                                <li><button title="Delete"><span class="fa fa-trash-o"></span></button></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" class="form-check-input"></td>
                                    <td style="width: 3%;">
                                        <div class="pxp-company-dashboard-candidate-avatar pxp-cover" style="background-image: url(images/ph-small.jpg);"></div>
                                    </td>
                                    <td>
                                        <a href="#">
                                            <div class="pxp-company-dashboard-job-title">Susanne Weil</div>
                                            <div class="pxp-company-dashboard-job-location"><span class="fa fa-globe me-1"></span>Los Angeles, CA</div>
                                        </a>
                                    </td>
                                    <td><div class="pxp-company-dashboard-job-category">UI Designer</div></td>
                                    <td><div class="pxp-company-dashboard-job-status"><span class="badge rounded-pill bg-success">Approved</span></div></td>
                                    <td>
                                        <div class="pxp-company-dashboard-job-date">2020/08/24 at 11:56 am</div>
                                    </td>
                                    <td>
                                        <div class="pxp-dashboard-table-options">
                                            <ul class="list-unstyled">
                                                <li><button title="View profile"><span class="fa fa-eye"></span></button></li>
                                                <li><button title="Send message"><span class="fa fa-envelope-o"></span></button></li>
                                                <li><button title="Approve"><span class="fa fa-check"></span></button></li>
                                                <li><button title="Reject"><span class="fa fa-ban"></span></button></li>
                                                <li><button title="Delete"><span class="fa fa-trash-o"></span></button></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" class="form-check-input"></td>
                                    <td style="width: 3%;">
                                        <div class="pxp-company-dashboard-candidate-avatar pxp-cover" style="background-image: url(images/ph-small.jpg);"></div>
                                    </td>
                                    <td>
                                        <a href="#">
                                            <div class="pxp-company-dashboard-job-title">Scott Goodwin</div>
                                            <div class="pxp-company-dashboard-job-location"><span class="fa fa-globe me-1"></span>San Francisco, CA</div>
                                        </a>
                                    </td>
                                    <td><div class="pxp-company-dashboard-job-category">Software Developer</div></td>
                                    <td><div class="pxp-company-dashboard-job-status"><span class="badge rounded-pill bg-success">Approved</span></div></td>
                                    <td>
                                        <div class="pxp-company-dashboard-job-date">2020/08/24 at 11:56 am</div>
                                    </td>
                                    <td>
                                        <div class="pxp-dashboard-table-options">
                                            <ul class="list-unstyled">
                                                <li><button title="View profile"><span class="fa fa-eye"></span></button></li>
                                                <li><button title="Send message"><span class="fa fa-envelope-o"></span></button></li>
                                                <li><button title="Approve"><span class="fa fa-check"></span></button></li>
                                                <li><button title="Reject"><span class="fa fa-ban"></span></button></li>
                                                <li><button title="Delete"><span class="fa fa-trash-o"></span></button></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" class="form-check-input"></td>
                                    <td style="width: 3%;">
                                        <div class="pxp-company-dashboard-candidate-avatar pxp-cover" style="background-image: url(images/ph-small.jpg);"></div>
                                    </td>
                                    <td>
                                        <a href="#">
                                            <div class="pxp-company-dashboard-job-title">Kenneth Spiers</div>
                                            <div class="pxp-company-dashboard-job-location"><span class="fa fa-globe me-1"></span>London, UK</div>
                                        </a>
                                    </td>
                                    <td><div class="pxp-company-dashboard-job-category">Marketing Expert</div></td>
                                    <td><div class="pxp-company-dashboard-job-status"><span class="badge rounded-pill bg-danger">Rejected</span></div></td>
                                    <td>
                                        <div class="pxp-company-dashboard-job-date">2020/08/24 at 11:56 am</div>
                                    </td>
                                    <td>
                                        <div class="pxp-dashboard-table-options">
                                            <ul class="list-unstyled">
                                                <li><button title="View profile"><span class="fa fa-eye"></span></button></li>
                                                <li><button title="Send message"><span class="fa fa-envelope-o"></span></button></li>
                                                <li><button title="Approve"><span class="fa fa-check"></span></button></li>
                                                <li><button title="Reject"><span class="fa fa-ban"></span></button></li>
                                                <li><button title="Delete"><span class="fa fa-trash-o"></span></button></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="row mt-4 mt-lg-5 justify-content-between align-items-center">
                            <div class="col-auto">
                                <nav class="mt-3 mt-sm-0" aria-label="Candidates pagination">
                                    <ul class="pagination pxp-pagination">
                                        <li class="page-item active" aria-current="page">
                                            <span class="page-link">1</span>
                                        </li>
                                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    </ul>
                                </nav>
                            </div>
                            <div class="col-auto">
                                <a href="#" class="btn rounded-pill pxp-section-cta mt-3 mt-sm-0">Show me more<span class="fa fa-angle-right"></span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?= view('layoutAdmin/footer.php'); ?>