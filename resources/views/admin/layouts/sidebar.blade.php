   <!-- ========== App Menu ========== -->
   <div class="app-menu navbar-menu">
       <!-- LOGO -->
       <div class="navbar-brand-box">
           <!-- Dark Logo-->
           <a href="index.html" class="logo logo-dark">
               <span class="logo-sm">
                   <img src="{{ asset('theme/admin/assets/images/logo-sm.png') }}" alt="" height="22">
               </span>
               <span class="logo-lg">
                   <img src="{{ asset('theme/admin/assets/images/logo-dark.png') }}" alt="" height="17">
               </span>
           </a>
           <!-- Light Logo-->
           <a href="index.html" class="logo logo-light">
               <span class="logo-sm">
                   <img src="{{ asset('theme/admin/assets/images/logo-sm.png') }}" alt="" height="22">
               </span>
               <span class="logo-lg">
                   <img src="{{ asset('theme/admin/assets/images/logo-light.png') }}" alt="" height="17">
               </span>
           </a>
           <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
               id="vertical-hover">
               <i class="ri-record-circle-line"></i>
           </button>
       </div>

       <div id="scrollbar">
           <div class="container-fluid">

               <div id="two-column-menu">
               </div>
               <ul class="navbar-nav" id="navbar-nav">
                   <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                   <li class="nav-item">
                       <a class="nav-link menu-link" href="#sidebarCatalogues" data-bs-toggle="collapse" role="button"
                           aria-expanded="false" aria-controls="sidebarCatalogues">
                           <i class="bx bx-menu"></i>
                           <span data-key="t-layouts">Danh mục sản phẩm</span>
                       </a>
                       <div class="collapse menu-dropdown" id="sidebarCatalogues">
                           <ul class="nav nav-sm flex-column">
                               <li class="nav-item">
                                   <a href="{{ route('admin.catalogues.index') }}" class="nav-link">Danh sách</a>
                               </li>
                               <li class="nav-item">
                                   <a href="{{ route('admin.catalogues.create') }}" class="nav-link">Thêm mới</a>
                               </li>
                           </ul>
                       </div>
                   </li>
                   <li class="nav-item">
                       <a class="nav-link menu-link" href="#sidebarUsers" data-bs-toggle="collapse" role="button"
                           aria-expanded="false" aria-controls="sidebarUsers">
                           <i class="bx bx-menu"></i>
                           <span data-key="t-layouts">Users</span>
                       </a>
                       <div class="collapse menu-dropdown" id="sidebarUsers">
                           <ul class="nav nav-sm flex-column">
                               <li class="nav-item">
                                   <a href="{{ route('admin.users.index') }}" class="nav-link">Danh sách</a>
                               </li>
                               <li class="nav-item">
                                   <a href="{{ route('admin.users.create') }}" class="nav-link">Thêm mới</a>
                               </li>
                           </ul>
                       </div>
                   </li>

                   <li class="nav-item">
                       <a class="nav-link menu-link" href="#sidebarVariant" data-bs-toggle="collapse" role="button"
                           aria-expanded="false" aria-controls="sidebarVariant">
                           <i class="ri-bubble-chart-fill"></i> <span data-key="t-authentication">Biến thể</span>
                       </a>
                       <div class="collapse menu-dropdown" id="sidebarVariant">
                           <ul class="nav nav-sm flex-column">
                               <li class="nav-item">
                                   <a href="#sidebarColor" class="nav-link" data-bs-toggle="collapse" role="button"
                                       aria-expanded="false" aria-controls="sidebarColor" data-key="t-signin">Color
                                   </a>
                                   <div class="collapse menu-dropdown" id="sidebarColor">
                                       <ul class="nav nav-sm flex-column">
                                           <li class="nav-item">
                                               <a href="{{ route('admin.productcolors.index') }}" class="nav-link"
                                                   data-key="t-basic"> Danh sách
                                               </a>
                                           </li>
                                           <li class="nav-item">
                                               <a href="{{ route('admin.productcolors.create') }}" class="nav-link"
                                                   data-key="t-cover"> Thêm mới
                                               </a>
                                           </li>
                                       </ul>
                                   </div>
                               </li>
                               <li class="nav-item">
                                   <a href="#sidebarSize" class="nav-link" data-bs-toggle="collapse" role="button"
                                       aria-expanded="false" aria-controls="sidebarSize" data-key="t-signin">Size
                                   </a>
                                   <div class="collapse menu-dropdown" id="sidebarSize">
                                       <ul class="nav nav-sm flex-column">
                                           <li class="nav-item">
                                               <a href="{{ route('admin.productsizes.index') }}" class="nav-link"
                                                   data-key="t-basic"> Danh sách
                                               </a>
                                           </li>
                                           <li class="nav-item">
                                               <a href="{{ route('admin.productsizes.create') }}" class="nav-link"
                                                   data-key="t-cover"> Thêm mới
                                               </a>
                                           </li>
                                       </ul>
                                   </div>
                               </li>
                           </ul>
                       </div>
                   </li>

                   <li class="nav-item">
                       <a href="#sidebarTags" class="nav-link" data-bs-toggle="collapse" role="button"
                           aria-expanded="false" aria-controls="sidebarTags" data-key="t-signin">
                           <i class="bx bx-font-size"></i>
                           Tag
                       </a>
                       <div class="collapse menu-dropdown" id="sidebarTags">
                           <ul class="nav nav-sm flex-column">
                               <li class="nav-item">
                                   <a href="{{ route('admin.tags.index') }}" class="nav-link" data-key="t-basic">
                                       Danh sách
                                   </a>
                               </li>
                               <li class="nav-item">
                                   <a href="{{ route('admin.tags.create') }}" class="nav-link" data-key="t-cover">
                                       Thêm mới
                                   </a>
                               </li>
                           </ul>
                       </div>
                   </li>

                   <li class="nav-item">
                       <a class="nav-link menu-link" href="#sidebarLayoutsProducts" data-bs-toggle="collapse"
                           role="button" aria-expanded="false" aria-controls="sidebarLayoutsProducts">
                           <i class="ri-layout-3-line"></i> <span data-key="t-layouts">Sản phẩm</span>
                       </a>
                       <div class="collapse menu-dropdown" id="sidebarLayoutsProducts">
                           <ul class="nav nav-sm flex-column">
                               <li class="nav-item">
                                   <a href="{{ route('admin.products.index') }}" class="nav-link"
                                       data-key="t-horizontal">Danh sách</a>
                               </li>
                               <li class="nav-item">
                                   <a href="{{ route('admin.products.create') }}" class="nav-link"
                                       data-key="t-horizontal">Thêm mới</a>
                               </li>
                           </ul>
                       </div>
                   </li>
                   <li class="nav-item">
                       <a class="nav-link menu-link" href="#sidebarCoupons" data-bs-toggle="collapse" role="button"
                           aria-expanded="false" aria-controls="sidebarCoupons">
                           <i class="bx bx-menu"></i>
                           <span data-key="t-layouts">Mã giảm giá</span>
                       </a>
                       <div class="collapse menu-dropdown" id="sidebarCoupons">
                           <ul class="nav nav-sm flex-column">
                               <li class="nav-item">
                                   <a href="{{ route('admin.coupons.index') }}" class="nav-link">Danh sách</a>
                               </li>
                               <li class="nav-item">
                                   <a href="{{ route('admin.coupons.create') }}" class="nav-link">Thêm mới</a>
                               </li>
                           </ul>
                       </div>
                   </li>
                   <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarStorage" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarStorage">
                        <i class="ri-bubble-chart-fill"></i> <span data-key="t-authentication">Kho hàng</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarStorage">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="#sidebarWareHouse" class="nav-link" data-bs-toggle="collapse"
                                    role="button" aria-expanded="false" aria-controls="sidebarwareHouse"
                                    data-key="t-signin">Thông tin kho
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarWareHouse">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('admin.warehouses.index') }}" class="nav-link"
                                                data-key="t-basic"> Danh sách
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('admin.warehouses.create') }}" class="nav-link"
                                                data-key="t-cover"> Thêm mới
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a href="#sidebarInventorie" class="nav-link" data-bs-toggle="collapse"
                                    role="button" aria-expanded="false" aria-controls="sidebarInventorie"
                                    data-key="t-signin">Quản lý kho
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarInventorie">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('admin.inventories.index') }}" class="nav-link"
                                                data-key="t-basic"> Danh sách
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>
               </ul>
           </div>
           <!-- Sidebar -->
       </div>

       <div class="sidebar-background"></div>
   </div>
   <!-- Left Sidebar End -->
