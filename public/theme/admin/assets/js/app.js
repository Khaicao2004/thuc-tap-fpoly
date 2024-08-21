!(function () {
    var d = document.querySelector(".navbar-menu").innerHTML,
        M = 7,
        t = "en",
        a = localStorage.getItem("language");
    function o() {
        n(null === a ? t : a);
        var e = document.getElementsByClassName("language");
        e &&
            Array.from(e).forEach(function (t) {
                t.addEventListener("click", function (e) {
                    n(t.getAttribute("data-lang"));
                });
            });
    }
    function n(e) {
        document.getElementById("header-lang-img") &&
            ("en" == e
                ? (document.getElementById("header-lang-img").src =
                     `${PATH_ROOT}/assets/images/flags/us.svg`)
                : "sp" == e
                ? (document.getElementById("header-lang-img").src =
                      `${PATH_ROOT}/assets/images/flags/spain.svg`)
                : "gr" == e
                ? (document.getElementById("header-lang-img").src =
                      `${PATH_ROOT}/assets/images/flags/germany.svg`)
                : "it" == e
                ? (document.getElementById("header-lang-img").src =
                      `${PATH_ROOT}/assets/images/flags/italy.svg`)
                : "ru" == e
                ? (document.getElementById("header-lang-img").src =
                      `${PATH_ROOT}/assets/images/flags/russia.svg`)
                : "ch" == e
                ? (document.getElementById("header-lang-img").src =
                      `${PATH_ROOT}/assets/images/flags/china.svg`)
                : "fr" == e
                ? (document.getElementById("header-lang-img").src =
                      `${PATH_ROOT}/assets/images/flags/french.svg`)
                : "ar" == e &&
                  (document.getElementById("header-lang-img").src =
                      `${PATH_ROOT}/assets/images/flags/ae.svg`),
            localStorage.setItem("language", e),
            null == (a = localStorage.getItem("language")) && n(t),
            (e = new XMLHttpRequest()).open(
                "GET",
                `${PATH_ROOT}/assets/lang/` + a + ".json"
            ),
            (e.onreadystatechange = function () {
                var a;
                4 === this.readyState &&
                    200 === this.status &&
                    ((a = JSON.parse(this.responseText)),
                    Object.keys(a).forEach(function (t) {
                        var e = document.querySelectorAll(
                            "[data-key='" + t + "']"
                        );
                        Array.from(e).forEach(function (e) {
                            e.textContent = a[t];
                        });
                    }));
            }),
            e.send());
    }
    function s() {
        var e;
        document.querySelectorAll(".navbar-nav .collapse") &&
            ((e = document.querySelectorAll(".navbar-nav .collapse")),
            Array.from(e).forEach(function (t) {
                var a = new bootstrap.Collapse(t, { toggle: !1 });
                t.addEventListener("show.bs.collapse", function (e) {
                    e.stopPropagation();
                    var e = t.parentElement.closest(".collapse");
                    e
                        ? ((e = e.querySelectorAll(".collapse")),
                          Array.from(e).forEach(function (e) {
                              e = bootstrap.Collapse.getInstance(e);
                              e !== a && e.hide();
                          }))
                        : ((e = (function (e) {
                              for (var t = [], a = e.parentNode.firstChild; a; )
                                  1 === a.nodeType && a !== e && t.push(a),
                                      (a = a.nextSibling);
                              return t;
                          })(t.parentElement)),
                          Array.from(e).forEach(function (e) {
                              2 < e.childNodes.length &&
                                  e.firstElementChild.setAttribute(
                                      "aria-expanded",
                                      "false"
                                  );
                              e = e.querySelectorAll("*[id]");
                              Array.from(e).forEach(function (e) {
                                  e.classList.remove("show"),
                                      2 < e.childNodes.length &&
                                          ((e = e.querySelectorAll("ul li a")),
                                          Array.from(e).forEach(function (e) {
                                              e.hasAttribute("aria-expanded") &&
                                                  e.setAttribute(
                                                      "aria-expanded",
                                                      "false"
                                                  );
                                          }));
                              });
                          }));
                }),
                    t.addEventListener("hide.bs.collapse", function (e) {
                        e.stopPropagation();
                        e = t.querySelectorAll(".collapse");
                        Array.from(e).forEach(function (e) {
                            (childCollapseInstance =
                                bootstrap.Collapse.getInstance(e)).hide();
                        });
                    });
            }));
    }
    function i() {
        var n,
            e = document.documentElement.getAttribute("data-layout"),
            t = sessionStorage.getItem("defaultAttribute"),
            t = JSON.parse(t);
        !t ||
            ("twocolumn" != e && "twocolumn" != t["data-layout"]) ||
            (document.querySelector(".navbar-menu") &&
                (document.querySelector(".navbar-menu").innerHTML = d),
            ((n = document.createElement("ul")).innerHTML =
                '<a href="#" class="logo"><img src="assets/images/logo-sm.png" alt="" height="22"></a>'),
            Array.from(
                document
                    .getElementById("navbar-nav")
                    .querySelectorAll(".menu-link")
            ).forEach(function (e) {
                n.className = "twocolumn-iconview";
                var t = document.createElement("li"),
                    a = e;
                a.querySelectorAll("span").forEach(function (e) {
                    e.classList.add("d-none");
                }),
                    e.parentElement.classList.contains("twocolumn-item-show") &&
                        e.classList.add("active"),
                    t.appendChild(a),
                    n.appendChild(t),
                    a.classList.contains("nav-link") &&
                        a.classList.replace("nav-link", "nav-icon"),
                    a.classList.remove("collapsed", "menu-link");
            }),
            (e = (e =
                "/" == location.pathname
                    ? "index.html"
                    : location.pathname.substring(1)).substring(
                e.lastIndexOf("/") + 1
            )) &&
                (t = document
                    .getElementById("navbar-nav")
                    .querySelector('[href="' + e + '"]')) &&
                (e = t.closest(".collapse.menu-dropdown")) &&
                (e.classList.add("show"),
                e.parentElement.children[0].classList.add("active"),
                e.parentElement.children[0].setAttribute(
                    "aria-expanded",
                    "true"
                ),
                e.parentElement.closest(".collapse.menu-dropdown")) &&
                (e.parentElement.closest(".collapse").classList.add("show"),
                e.parentElement.closest(".collapse").previousElementSibling &&
                    e.parentElement
                        .closest(".collapse")
                        .previousElementSibling.classList.add("active"),
                e.parentElement.parentElement.parentElement.parentElement.closest(
                    ".collapse.menu-dropdown"
                )) &&
                (e.parentElement.parentElement.parentElement.parentElement
                    .closest(".collapse")
                    .classList.add("show"),
                e.parentElement.parentElement.parentElement.parentElement.closest(
                    ".collapse"
                ).previousElementSibling) &&
                e.parentElement.parentElement.parentElement.parentElement
                    .closest(".collapse")
                    .previousElementSibling.classList.add("active"),
            (document.getElementById("two-column-menu").innerHTML =
                n.outerHTML),
            Array.from(
                document
                    .querySelector("#two-column-menu ul")
                    .querySelectorAll("li a")
            ).forEach(function (a) {
                var n = (n =
                    "/" == location.pathname
                        ? "index.html"
                        : location.pathname.substring(1)).substring(
                    n.lastIndexOf("/") + 1
                );
                a.addEventListener("click", function (e) {
                    var t;
                    (n != "/" + a.getAttribute("href") ||
                        a.getAttribute("data-bs-toggle")) &&
                        document.body.classList.contains("twocolumn-panel") &&
                        document.body.classList.remove("twocolumn-panel"),
                        document
                            .getElementById("navbar-nav")
                            .classList.remove("twocolumn-nav-hide"),
                        document
                            .querySelector(".hamburger-icon")
                            .classList.remove("open"),
                        ((e.target && e.target.matches("a.nav-icon")) ||
                            (e.target && e.target.matches("i"))) &&
                            (null !==
                                document.querySelector(
                                    "#two-column-menu ul .nav-icon.active"
                                ) &&
                                document
                                    .querySelector(
                                        "#two-column-menu ul .nav-icon.active"
                                    )
                                    .classList.remove("active"),
                            (e.target.matches("i")
                                ? e.target.closest("a")
                                : e.target
                            ).classList.add("active"),
                            0 <
                                (t = document.getElementsByClassName(
                                    "twocolumn-item-show"
                                )).length &&
                                t[0].classList.remove("twocolumn-item-show"),
                            (t = (
                                e.target.matches("i")
                                    ? e.target.closest("a")
                                    : e.target
                            )
                                .getAttribute("href")
                                .slice(1)),
                            document.getElementById(t)) &&
                            document
                                .getElementById(t)
                                .parentElement.classList.add(
                                    "twocolumn-item-show"
                                );
                }),
                    n != "/" + a.getAttribute("href") ||
                        a.getAttribute("data-bs-toggle") ||
                        (a.classList.add("active"),
                        document
                            .getElementById("navbar-nav")
                            .classList.add("twocolumn-nav-hide"),
                        document.querySelector(".hamburger-icon") &&
                            document
                                .querySelector(".hamburger-icon")
                                .classList.add("open"));
            }),
            "horizontal" !==
                document.documentElement.getAttribute("data-layout") &&
                ((t = new SimpleBar(document.getElementById("navbar-nav"))) &&
                    t.getContentElement(),
                (e = new SimpleBar(
                    document.getElementsByClassName("twocolumn-iconview")[0]
                ))) &&
                e.getContentElement());
    }
    function l(e) {
        if (e) {
            var t = e.offsetTop,
                a = e.offsetLeft,
                n = e.offsetWidth,
                o = e.offsetHeight;
            if (e.offsetParent)
                for (; e.offsetParent; )
                    (t += (e = e.offsetParent).offsetTop), (a += e.offsetLeft);
            return (
                t >= window.pageYOffset &&
                a >= window.pageXOffset &&
                t + o <= window.pageYOffset + window.innerHeight &&
                a + n <= window.pageXOffset + window.innerWidth
            );
        }
    }
    function r() {
        ("vertical" != document.documentElement.getAttribute("data-layout") &&
            "semibox" !=
                document.documentElement.getAttribute("data-layout")) ||
            ((document.getElementById("two-column-menu").innerHTML = ""),
            document.querySelector(".navbar-menu") &&
                (document.querySelector(".navbar-menu").innerHTML = d),
            document
                .getElementById("scrollbar")
                .setAttribute("data-simplebar", ""),
            document
                .getElementById("navbar-nav")
                .setAttribute("data-simplebar", ""),
            document.getElementById("scrollbar").classList.add("h-100")),
            "twocolumn" ==
                document.documentElement.getAttribute("data-layout") &&
                (document
                    .getElementById("scrollbar")
                    .removeAttribute("data-simplebar"),
                document.getElementById("scrollbar").classList.remove("h-100")),
            "horizontal" ==
                document.documentElement.getAttribute("data-layout") && b();
    }
    function m() {
        feather.replace();
        var e = document.documentElement.clientWidth,
            e =
                (e < 1025 && 767 < e
                    ? (document.body.classList.remove("twocolumn-panel"),
                      "twocolumn" == sessionStorage.getItem("data-layout") &&
                          (document.documentElement.setAttribute(
                              "data-layout",
                              "twocolumn"
                          ),
                          document.getElementById("customizer-layout03") &&
                              document
                                  .getElementById("customizer-layout03")
                                  .click(),
                          i(),
                          u(),
                          s()),
                      "vertical" == sessionStorage.getItem("data-layout") &&
                          document.documentElement.setAttribute(
                              "data-sidebar-size",
                              "sm"
                          ),
                      "semibox" == sessionStorage.getItem("data-layout") &&
                          document.documentElement.setAttribute(
                              "data-sidebar-size",
                              "sm"
                          ),
                      document.querySelector(".hamburger-icon") &&
                          document
                              .querySelector(".hamburger-icon")
                              .classList.add("open"))
                    : 1025 <= e
                    ? (document.body.classList.remove("twocolumn-panel"),
                      "twocolumn" == sessionStorage.getItem("data-layout") &&
                          (document.documentElement.setAttribute(
                              "data-layout",
                              "twocolumn"
                          ),
                          document.getElementById("customizer-layout03") &&
                              document
                                  .getElementById("customizer-layout03")
                                  .click(),
                          i(),
                          u(),
                          s()),
                      "vertical" == sessionStorage.getItem("data-layout") &&
                          document.documentElement.setAttribute(
                              "data-sidebar-size",
                              sessionStorage.getItem("data-sidebar-size")
                          ),
                      "semibox" == sessionStorage.getItem("data-layout") &&
                          document.documentElement.setAttribute(
                              "data-sidebar-size",
                              sessionStorage.getItem("data-sidebar-size")
                          ),
                      document.querySelector(".hamburger-icon") &&
                          document
                              .querySelector(".hamburger-icon")
                              .classList.remove("open"))
                    : e <= 767 &&
                      (document.body.classList.remove(
                          "vertical-sidebar-enable"
                      ),
                      document.body.classList.add("twocolumn-panel"),
                      "twocolumn" == sessionStorage.getItem("data-layout") &&
                          (document.documentElement.setAttribute(
                              "data-layout",
                              "vertical"
                          ),
                          y("vertical"),
                          s()),
                      "horizontal" != sessionStorage.getItem("data-layout") &&
                          document.documentElement.setAttribute(
                              "data-sidebar-size",
                              "lg"
                          ),
                      document.querySelector(".hamburger-icon")) &&
                      document
                          .querySelector(".hamburger-icon")
                          .classList.add("open"),
                document.querySelectorAll("#navbar-nav > li.nav-item"));
        Array.from(e).forEach(function (e) {
            e.addEventListener("click", c.bind(this), !1),
                e.addEventListener("mouseover", c.bind(this), !1);
        });
    }
    function c(e) {
        if (e.target && e.target.matches("a.nav-link span"))
            if (0 == l(e.target.parentElement.nextElementSibling)) {
                e.target.parentElement.nextElementSibling.classList.add(
                    "dropdown-custom-right"
                ),
                    e.target.parentElement.parentElement.parentElement.parentElement.classList.add(
                        "dropdown-custom-right"
                    );
                var t = e.target.parentElement.nextElementSibling;
                Array.from(t.querySelectorAll(".menu-dropdown")).forEach(
                    function (e) {
                        e.classList.add("dropdown-custom-right");
                    }
                );
            } else if (
                1 == l(e.target.parentElement.nextElementSibling) &&
                1848 <= window.innerWidth
            )
                for (
                    var a = document.getElementsByClassName(
                        "dropdown-custom-right"
                    );
                    0 < a.length;

                )
                    a[0].classList.remove("dropdown-custom-right");
        if (e.target && e.target.matches("a.nav-link"))
            if (0 == l(e.target.nextElementSibling)) {
                e.target.nextElementSibling.classList.add(
                    "dropdown-custom-right"
                ),
                    e.target.parentElement.parentElement.parentElement.classList.add(
                        "dropdown-custom-right"
                    );
                t = e.target.nextElementSibling;
                Array.from(t.querySelectorAll(".menu-dropdown")).forEach(
                    function (e) {
                        e.classList.add("dropdown-custom-right");
                    }
                );
            } else if (
                1 == l(e.target.nextElementSibling) &&
                1848 <= window.innerWidth
            )
                for (
                    a = document.getElementsByClassName(
                        "dropdown-custom-right"
                    );
                    0 < a.length;

                )
                    a[0].classList.remove("dropdown-custom-right");
    }
    function O() {
        var e = document.documentElement.clientWidth;
        767 < e &&
            document.querySelector(".hamburger-icon").classList.toggle("open"),
            "horizontal" ===
                document.documentElement.getAttribute("data-layout") &&
                (document.body.classList.contains("menu")
                    ? document.body.classList.remove("menu")
                    : document.body.classList.add("menu")),
            "vertical" ===
                document.documentElement.getAttribute("data-layout") &&
                (e <= 1025 && 767 < e
                    ? (document.body.classList.remove(
                          "vertical-sidebar-enable"
                      ),
                      "sm" ==
                      document.documentElement.getAttribute("data-sidebar-size")
                          ? document.documentElement.setAttribute(
                                "data-sidebar-size",
                                ""
                            )
                          : document.documentElement.setAttribute(
                                "data-sidebar-size",
                                "sm"
                            ))
                    : 1025 < e
                    ? (document.body.classList.remove(
                          "vertical-sidebar-enable"
                      ),
                      "lg" ==
                      document.documentElement.getAttribute("data-sidebar-size")
                          ? document.documentElement.setAttribute(
                                "data-sidebar-size",
                                "sm"
                            )
                          : document.documentElement.setAttribute(
                                "data-sidebar-size",
                                "lg"
                            ))
                    : e <= 767 &&
                      (document.body.classList.add("vertical-sidebar-enable"),
                      document.documentElement.setAttribute(
                          "data-sidebar-size",
                          "lg"
                      ))),
            "semibox" ===
                document.documentElement.getAttribute("data-layout") &&
                (767 < e
                    ? "show" ==
                      document.documentElement.getAttribute(
                          "data-sidebar-visibility"
                      )
                        ? "lg" ==
                          document.documentElement.getAttribute(
                              "data-sidebar-size"
                          )
                            ? document.documentElement.setAttribute(
                                  "data-sidebar-size",
                                  "sm"
                              )
                            : document.documentElement.setAttribute(
                                  "data-sidebar-size",
                                  "lg"
                              )
                        : (document
                              .getElementById("sidebar-visibility-show")
                              .click(),
                          document.documentElement.setAttribute(
                              "data-sidebar-size",
                              document.documentElement.getAttribute(
                                  "data-sidebar-size"
                              )
                          ))
                    : e <= 767 &&
                      (document.body.classList.add("vertical-sidebar-enable"),
                      document.documentElement.setAttribute(
                          "data-sidebar-size",
                          "lg"
                      ))),
            "twocolumn" ==
                document.documentElement.getAttribute("data-layout") &&
                (document.body.classList.contains("twocolumn-panel")
                    ? document.body.classList.remove("twocolumn-panel")
                    : document.body.classList.add("twocolumn-panel"));
    }
    function G() {
        document.addEventListener("DOMContentLoaded", function () {
            var e = document.getElementsByClassName("code-switcher");
            Array.from(e).forEach(function (a) {
                a.addEventListener("change", function () {
                    var e = a.closest(".card"),
                        t = e.querySelector(".live-preview"),
                        e = e.querySelector(".code-view");
                    a.checked
                        ? (t.classList.add("d-none"),
                          e.classList.remove("d-none"))
                        : (t.classList.remove("d-none"),
                          e.classList.add("d-none"));
                });
            }),
                feather.replace();
        }),
            window.addEventListener("resize", m),
            m(),
            Waves.init(),
            document.addEventListener("scroll", function () {
                var e;
                (e = document.getElementById("page-topbar")) &&
                    (50 <= document.body.scrollTop ||
                    50 <= document.documentElement.scrollTop
                        ? e.classList.add("topbar-shadow")
                        : e.classList.remove("topbar-shadow"));
            }),
            window.addEventListener("load", function () {
                var e;
                ("twocolumn" ==
                    document.documentElement.getAttribute("data-layout")
                    ? u
                    : g)(),
                    (e = document.getElementsByClassName("vertical-overlay")) &&
                        Array.from(e).forEach(function (e) {
                            e.addEventListener("click", function () {
                                document.body.classList.remove(
                                    "vertical-sidebar-enable"
                                ),
                                    "twocolumn" ==
                                    sessionStorage.getItem("data-layout")
                                        ? document.body.classList.add(
                                              "twocolumn-panel"
                                          )
                                        : document.documentElement.setAttribute(
                                              "data-sidebar-size",
                                              sessionStorage.getItem(
                                                  "data-sidebar-size"
                                              )
                                          );
                            });
                        }),
                    E();
            }),
            document.getElementById("topnav-hamburger-icon") &&
                document
                    .getElementById("topnav-hamburger-icon")
                    .addEventListener("click", O);
        var e = sessionStorage.getItem("defaultAttribute"),
            e = JSON.parse(e),
            t = document.documentElement.clientWidth;
        "twocolumn" == e["data-layout"] &&
            t < 767 &&
            Array.from(
                document
                    .getElementById("two-column-menu")
                    .querySelectorAll("li")
            ).forEach(function (e) {
                e.addEventListener("click", function (e) {
                    document.body.classList.remove("twocolumn-panel");
                });
            });
    }
    function u() {
        feather.replace();
        var e,
            t,
            a =
                "/" == location.pathname
                    ? "index.html"
                    : location.pathname.substring(1);
        (a = a.substring(a.lastIndexOf("/") + 1)) &&
            ("twocolumn-panel" == document.body.className &&
                document
                    .getElementById("two-column-menu")
                    .querySelector('[href="' + a + '"]')
                    .classList.add("active"),
            (a = document
                .getElementById("navbar-nav")
                .querySelector('[href="' + a + '"]'))
                ? (a.classList.add("active"),
                  (t = (
                      (e = a.closest(".collapse.menu-dropdown")) &&
                      e.parentElement.closest(".collapse.menu-dropdown")
                          ? (e.classList.add("show"),
                            e.parentElement.children[0].classList.add("active"),
                            e.parentElement
                                .closest(".collapse.menu-dropdown")
                                .parentElement.classList.add(
                                    "twocolumn-item-show"
                                ),
                            e.parentElement.parentElement.parentElement.parentElement.closest(
                                ".collapse.menu-dropdown"
                            ) &&
                                ((t =
                                    e.parentElement.parentElement.parentElement.parentElement
                                        .closest(".collapse.menu-dropdown")
                                        .getAttribute("id")),
                                e.parentElement.parentElement.parentElement.parentElement
                                    .closest(".collapse.menu-dropdown")
                                    .parentElement.classList.add(
                                        "twocolumn-item-show"
                                    ),
                                e.parentElement
                                    .closest(".collapse.menu-dropdown")
                                    .parentElement.classList.remove(
                                        "twocolumn-item-show"
                                    ),
                                document
                                    .getElementById("two-column-menu")
                                    .querySelector('[href="#' + t + '"]')) &&
                                document
                                    .getElementById("two-column-menu")
                                    .querySelector('[href="#' + t + '"]')
                                    .classList.add("active"),
                            e.parentElement.closest(".collapse.menu-dropdown"))
                          : (a
                                .closest(".collapse.menu-dropdown")
                                .parentElement.classList.add(
                                    "twocolumn-item-show"
                                ),
                            e)
                  ).getAttribute("id")),
                  document
                      .getElementById("two-column-menu")
                      .querySelector('[href="#' + t + '"]') &&
                      document
                          .getElementById("two-column-menu")
                          .querySelector('[href="#' + t + '"]')
                          .classList.add("active"))
                : document.body.classList.add("twocolumn-panel"));
    }
    function g() {
        var e =
            "/" == location.pathname
                ? "index.html"
                : location.pathname.substring(1);
        (e = e.substring(e.lastIndexOf("/") + 1)) &&
            (e = document
                .getElementById("navbar-nav")
                .querySelector('[href="' + e + '"]')) &&
            (e.classList.add("active"),
            (e = e.closest(".collapse.menu-dropdown"))) &&
            (e.classList.add("show"),
            e.parentElement.children[0].classList.add("active"),
            e.parentElement.children[0].setAttribute("aria-expanded", "true"),
            e.parentElement.closest(".collapse.menu-dropdown")) &&
            (e.parentElement.closest(".collapse").classList.add("show"),
            e.parentElement.closest(".collapse").previousElementSibling &&
                e.parentElement
                    .closest(".collapse")
                    .previousElementSibling.classList.add("active"),
            e.parentElement.parentElement.parentElement.parentElement.closest(
                ".collapse.menu-dropdown"
            )) &&
            (e.parentElement.parentElement.parentElement.parentElement
                .closest(".collapse")
                .classList.add("show"),
            e.parentElement.parentElement.parentElement.parentElement.closest(
                ".collapse"
            ).previousElementSibling) &&
            (e.parentElement.parentElement.parentElement.parentElement
                .closest(".collapse")
                .previousElementSibling.classList.add("active"),
            "horizontal" ==
                document.documentElement.getAttribute("data-layout")) &&
            e.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.closest(
                ".collapse"
            ) &&
            e.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement
                .closest(".collapse")
                .previousElementSibling.classList.add("active");
    }
    function l(e) {
        if (e) {
            var t = e.offsetTop,
                a = e.offsetLeft,
                n = e.offsetWidth,
                o = e.offsetHeight;
            if (e.offsetParent)
                for (; e.offsetParent; )
                    (t += (e = e.offsetParent).offsetTop), (a += e.offsetLeft);
            return (
                t >= window.pageYOffset &&
                a >= window.pageXOffset &&
                t + o <= window.pageYOffset + window.innerHeight &&
                a + n <= window.pageXOffset + window.innerWidth
            );
        }
    }
    function D() {
        var e = document.querySelectorAll(".counter-value");
        function s(e) {
            return e.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
        e &&
            Array.from(e).forEach(function (o) {
                !(function e() {
                    var t = +o.getAttribute("data-target"),
                        a = +o.innerText,
                        n = t / 250;
                    n < 1 && (n = 1),
                        a < t
                            ? ((o.innerText = (a + n).toFixed(0)),
                              setTimeout(e, 1))
                            : (o.innerText = s(t)),
                        s(o.innerText);
                })();
            });
    }
    function b() {
        (document.getElementById("two-column-menu").innerHTML = ""),
            document.querySelector(".navbar-menu") &&
                (document.querySelector(".navbar-menu").innerHTML = d),
            document
                .getElementById("scrollbar")
                .removeAttribute("data-simplebar"),
            document
                .getElementById("navbar-nav")
                .removeAttribute("data-simplebar"),
            document.getElementById("scrollbar").classList.remove("h-100");
        var a = M,
            n = document.querySelectorAll("ul.navbar-nav > li.nav-item"),
            o = "",
            s = "";
        Array.from(n).forEach(function (e, t) {
            t + 1 === a && (s = e),
                a < t + 1 && ((o += e.outerHTML), e.remove()),
                t + 1 === n.length &&
                    s.insertAdjacentHTML &&
                    s.insertAdjacentHTML(
                        "afterend",
                        '<li class="nav-item">\t\t\t\t\t\t<a class="nav-link" href="#sidebarMore" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarMore">\t\t\t\t\t\t\t<i class="ri-briefcase-2-line"></i> <span data-key="t-more">More</span>\t\t\t\t\t\t</a>\t\t\t\t\t\t<div class="collapse menu-dropdown" id="sidebarMore"><ul class="nav nav-sm flex-column">' +
                            o +
                            "</ul></div>\t\t\t\t\t</li>"
                    );
        });
    }
    function y(e) {
        "vertical" == e
            ? ((document.getElementById("two-column-menu").innerHTML = ""),
              document.querySelector(".navbar-menu") &&
                  (document.querySelector(".navbar-menu").innerHTML = d),
              document.getElementById("theme-settings-offcanvas") &&
                  ((document.getElementById("sidebar-size").style.display =
                      "block"),
                  (document.getElementById("sidebar-view").style.display =
                      "block"),
                  (document.getElementById("sidebar-color").style.display =
                      "block"),
                  document.getElementById("sidebar-img") &&
                      (document.getElementById("sidebar-img").style.display =
                          "block"),
                  (document.getElementById("layout-position").style.display =
                      "block"),
                  (document.getElementById("layout-width").style.display =
                      "block"),
                  (document.getElementById("sidebar-visibility").style.display =
                      "none")),
              r(),
              g(),
              E(),
              p())
            : "horizontal" == e
            ? (b(),
              document.getElementById("theme-settings-offcanvas") &&
                  ((document.getElementById("sidebar-size").style.display =
                      "none"),
                  (document.getElementById("sidebar-view").style.display =
                      "none"),
                  (document.getElementById("sidebar-color").style.display =
                      "none"),
                  document.getElementById("sidebar-img") &&
                      (document.getElementById("sidebar-img").style.display =
                          "none"),
                  (document.getElementById("layout-position").style.display =
                      "block"),
                  (document.getElementById("layout-width").style.display =
                      "block"),
                  (document.getElementById("sidebar-visibility").style.display =
                      "none")),
              g())
            : "twocolumn" == e
            ? (document
                  .getElementById("scrollbar")
                  .removeAttribute("data-simplebar"),
              document.getElementById("scrollbar").classList.remove("h-100"),
              document.getElementById("theme-settings-offcanvas") &&
                  ((document.getElementById("sidebar-size").style.display =
                      "none"),
                  (document.getElementById("sidebar-view").style.display =
                      "none"),
                  (document.getElementById("sidebar-color").style.display =
                      "block"),
                  document.getElementById("sidebar-img") &&
                      (document.getElementById("sidebar-img").style.display =
                          "block"),
                  (document.getElementById("layout-position").style.display =
                      "none"),
                  (document.getElementById("layout-width").style.display =
                      "none"),
                  (document.getElementById("sidebar-visibility").style.display =
                      "none")))
            : "semibox" == e &&
              ((document.getElementById("two-column-menu").innerHTML = ""),
              document.querySelector(".navbar-menu") &&
                  (document.querySelector(".navbar-menu").innerHTML = d),
              document.getElementById("theme-settings-offcanvas") &&
                  ((document.getElementById("sidebar-size").style.display =
                      "block"),
                  (document.getElementById("sidebar-view").style.display =
                      "none"),
                  (document.getElementById("sidebar-color").style.display =
                      "block"),
                  document.getElementById("sidebar-img") &&
                      (document.getElementById("sidebar-img").style.display =
                          "block"),
                  (document.getElementById("layout-position").style.display =
                      "block"),
                  (document.getElementById("layout-width").style.display =
                      "none"),
                  (document.getElementById("sidebar-visibility").style.display =
                      "block")),
              r(),
              g(),
              E(),
              p());
    }
    function E() {
        document
            .getElementById("vertical-hover")
            .addEventListener("click", function () {
                "sm-hover" ===
                document.documentElement.getAttribute("data-sidebar-size")
                    ? document.documentElement.setAttribute(
                          "data-sidebar-size",
                          "sm-hover-active"
                      )
                    : (document.documentElement.getAttribute(
                          "data-sidebar-size"
                      ),
                      document.documentElement.setAttribute(
                          "data-sidebar-size",
                          "sm-hover"
                      ));
            });
    }
    function e(e) {
        if (e == e) {
            switch (e["data-layout"]) {
                case "vertical":
                    T("data-layout", "vertical"),
                        sessionStorage.setItem("data-layout", "vertical"),
                        document.documentElement.setAttribute(
                            "data-layout",
                            "vertical"
                        ),
                        y("vertical"),
                        s();
                    break;
                case "horizontal":
                    T("data-layout", "horizontal"),
                        sessionStorage.setItem("data-layout", "horizontal"),
                        document.documentElement.setAttribute(
                            "data-layout",
                            "horizontal"
                        ),
                        y("horizontal");
                    break;
                case "twocolumn":
                    T("data-layout", "twocolumn"),
                        sessionStorage.setItem("data-layout", "twocolumn"),
                        document.documentElement.setAttribute(
                            "data-layout",
                            "twocolumn"
                        ),
                        y("twocolumn");
                    break;
                case "semibox":
                    T("data-layout", "semibox"),
                        sessionStorage.setItem("data-layout", "semibox"),
                        document.documentElement.setAttribute(
                            "data-layout",
                            "semibox"
                        ),
                        y("semibox");
                    break;
                default:
                    "vertical" == sessionStorage.getItem("data-layout") &&
                    sessionStorage.getItem("data-layout")
                        ? (T("data-layout", "vertical"),
                          sessionStorage.setItem("data-layout", "vertical"),
                          document.documentElement.setAttribute(
                              "data-layout",
                              "vertical"
                          ),
                          y("vertical"),
                          s())
                        : "horizontal" == sessionStorage.getItem("data-layout")
                        ? (T("data-layout", "horizontal"),
                          sessionStorage.setItem("data-layout", "horizontal"),
                          document.documentElement.setAttribute(
                              "data-layout",
                              "horizontal"
                          ),
                          y("horizontal"))
                        : "twocolumn" == sessionStorage.getItem("data-layout")
                        ? (T("data-layout", "twocolumn"),
                          sessionStorage.setItem("data-layout", "twocolumn"),
                          document.documentElement.setAttribute(
                              "data-layout",
                              "twocolumn"
                          ),
                          y("twocolumn"))
                        : "semibox" == sessionStorage.getItem("data-layout") &&
                          (T("data-layout", "semibox"),
                          sessionStorage.setItem("data-layout", "semibox"),
                          document.documentElement.setAttribute(
                              "data-layout",
                              "semibox"
                          ),
                          y("semibox"));
            }
            switch (e["data-topbar"]) {
                case "light":
                    T("data-topbar", "light"),
                        sessionStorage.setItem("data-topbar", "light"),
                        document.documentElement.setAttribute(
                            "data-topbar",
                            "light"
                        );
                    break;
                case "dark":
                    T("data-topbar", "dark"),
                        sessionStorage.setItem("data-topbar", "dark"),
                        document.documentElement.setAttribute(
                            "data-topbar",
                            "dark"
                        );
                    break;
                default:
                    "dark" == sessionStorage.getItem("data-topbar")
                        ? (T("data-topbar", "dark"),
                          sessionStorage.setItem("data-topbar", "dark"),
                          document.documentElement.setAttribute(
                              "data-topbar",
                              "dark"
                          ))
                        : (T("data-topbar", "light"),
                          sessionStorage.setItem("data-topbar", "light"),
                          document.documentElement.setAttribute(
                              "data-topbar",
                              "light"
                          ));
            }
            switch (
                ("hidden" === e["data-sidebar-visibility"]
                    ? (T("data-sidebar-visibility", "hidden"),
                      sessionStorage.setItem(
                          "data-sidebar-visibility",
                          "hidden"
                      ),
                      document.documentElement.setAttribute(
                          "data-sidebar-visibility",
                          "hidden"
                      ))
                    : (T("data-sidebar-visibility", "show"),
                      sessionStorage.setItem("data-sidebar-visibility", "show"),
                      document.documentElement.setAttribute(
                          "data-sidebar-visibility",
                          "show"
                      )),
                e["data-layout-style"])
            ) {
                case "default":
                    T("data-layout-style", "default"),
                        sessionStorage.setItem("data-layout-style", "default"),
                        document.documentElement.setAttribute(
                            "data-layout-style",
                            "default"
                        );
                    break;
                case "detached":
                    T("data-layout-style", "detached"),
                        sessionStorage.setItem("data-layout-style", "detached"),
                        document.documentElement.setAttribute(
                            "data-layout-style",
                            "detached"
                        );
                    break;
                default:
                    "detached" == sessionStorage.getItem("data-layout-style")
                        ? (T("data-layout-style", "detached"),
                          sessionStorage.setItem(
                              "data-layout-style",
                              "detached"
                          ),
                          document.documentElement.setAttribute(
                              "data-layout-style",
                              "detached"
                          ))
                        : (T("data-layout-style", "default"),
                          sessionStorage.setItem(
                              "data-layout-style",
                              "default"
                          ),
                          document.documentElement.setAttribute(
                              "data-layout-style",
                              "default"
                          ));
            }
            switch (e["data-sidebar-size"]) {
                case "lg":
                    T("data-sidebar-size", "lg"),
                        document.documentElement.setAttribute(
                            "data-sidebar-size",
                            "lg"
                        ),
                        sessionStorage.setItem("data-sidebar-size", "lg");
                    break;
                case "sm":
                    T("data-sidebar-size", "sm"),
                        document.documentElement.setAttribute(
                            "data-sidebar-size",
                            "sm"
                        ),
                        sessionStorage.setItem("data-sidebar-size", "sm");
                    break;
                case "md":
                    T("data-sidebar-size", "md"),
                        document.documentElement.setAttribute(
                            "data-sidebar-size",
                            "md"
                        ),
                        sessionStorage.setItem("data-sidebar-size", "md");
                    break;
                case "sm-hover":
                    T("data-sidebar-size", "sm-hover"),
                        document.documentElement.setAttribute(
                            "data-sidebar-size",
                            "sm-hover"
                        ),
                        sessionStorage.setItem("data-sidebar-size", "sm-hover");
                    break;
                default:
                    "sm" == sessionStorage.getItem("data-sidebar-size")
                        ? (document.documentElement.setAttribute(
                              "data-sidebar-size",
                              "sm"
                          ),
                          T("data-sidebar-size", "sm"),
                          sessionStorage.setItem("data-sidebar-size", "sm"))
                        : "md" == sessionStorage.getItem("data-sidebar-size")
                        ? (document.documentElement.setAttribute(
                              "data-sidebar-size",
                              "md"
                          ),
                          T("data-sidebar-size", "md"),
                          sessionStorage.setItem("data-sidebar-size", "md"))
                        : "sm-hover" ==
                          sessionStorage.getItem("data-sidebar-size")
                        ? (document.documentElement.setAttribute(
                              "data-sidebar-size",
                              "sm-hover"
                          ),
                          T("data-sidebar-size", "sm-hover"),
                          sessionStorage.setItem(
                              "data-sidebar-size",
                              "sm-hover"
                          ))
                        : (document.documentElement.setAttribute(
                              "data-sidebar-size",
                              "lg"
                          ),
                          T("data-sidebar-size", "lg"),
                          sessionStorage.setItem("data-sidebar-size", "lg"));
            }
            switch (e["data-bs-theme"]) {
                case "light":
                    T("data-bs-theme", "light"),
                        document.documentElement.setAttribute(
                            "data-bs-theme",
                            "light"
                        ),
                        sessionStorage.setItem("data-bs-theme", "light");
                    break;
                case "dark":
                    T("data-bs-theme", "dark"),
                        document.documentElement.setAttribute(
                            "data-bs-theme",
                            "dark"
                        ),
                        sessionStorage.setItem("data-bs-theme", "dark");
                    break;
                default:
                    sessionStorage.getItem("data-bs-theme") &&
                    "dark" == sessionStorage.getItem("data-bs-theme")
                        ? (sessionStorage.setItem("data-bs-theme", "dark"),
                          document.documentElement.setAttribute(
                              "data-bs-theme",
                              "dark"
                          ),
                          T("data-bs-theme", "dark"))
                        : (sessionStorage.setItem("data-bs-theme", "light"),
                          document.documentElement.setAttribute(
                              "data-bs-theme",
                              "light"
                          ),
                          T("data-bs-theme", "light"));
            }
            switch (e["data-layout-width"]) {
                case "fluid":
                    T("data-layout-width", "fluid"),
                        document.documentElement.setAttribute(
                            "data-layout-width",
                            "fluid"
                        ),
                        sessionStorage.setItem("data-layout-width", "fluid");
                    break;
                case "boxed":
                    T("data-layout-width", "boxed"),
                        document.documentElement.setAttribute(
                            "data-layout-width",
                            "boxed"
                        ),
                        sessionStorage.setItem("data-layout-width", "boxed");
                    break;
                default:
                    "boxed" == sessionStorage.getItem("data-layout-width")
                        ? (sessionStorage.setItem("data-layout-width", "boxed"),
                          document.documentElement.setAttribute(
                              "data-layout-width",
                              "boxed"
                          ),
                          T("data-layout-width", "boxed"))
                        : (sessionStorage.setItem("data-layout-width", "fluid"),
                          document.documentElement.setAttribute(
                              "data-layout-width",
                              "fluid"
                          ),
                          T("data-layout-width", "fluid"));
            }
            switch (e["data-sidebar"]) {
                case "light":
                    T("data-sidebar", "light"),
                        sessionStorage.setItem("data-sidebar", "light"),
                        document.documentElement.setAttribute(
                            "data-sidebar",
                            "light"
                        );
                    break;
                case "dark":
                    T("data-sidebar", "dark"),
                        sessionStorage.setItem("data-sidebar", "dark"),
                        document.documentElement.setAttribute(
                            "data-sidebar",
                            "dark"
                        );
                    break;
                case "gradient":
                    T("data-sidebar", "gradient"),
                        sessionStorage.setItem("data-sidebar", "gradient"),
                        document.documentElement.setAttribute(
                            "data-sidebar",
                            "gradient"
                        );
                    break;
                case "gradient-2":
                    T("data-sidebar", "gradient-2"),
                        sessionStorage.setItem("data-sidebar", "gradient-2"),
                        document.documentElement.setAttribute(
                            "data-sidebar",
                            "gradient-2"
                        );
                    break;
                case "gradient-3":
                    T("data-sidebar", "gradient-3"),
                        sessionStorage.setItem("data-sidebar", "gradient-3"),
                        document.documentElement.setAttribute(
                            "data-sidebar",
                            "gradient-3"
                        );
                    break;
                case "gradient-4":
                    T("data-sidebar", "gradient-4"),
                        sessionStorage.setItem("data-sidebar", "gradient-4"),
                        document.documentElement.setAttribute(
                            "data-sidebar",
                            "gradient-4"
                        );
                    break;
                default:
                    sessionStorage.getItem("data-sidebar") &&
                    "light" == sessionStorage.getItem("data-sidebar")
                        ? (sessionStorage.setItem("data-sidebar", "light"),
                          T("data-sidebar", "light"),
                          document.documentElement.setAttribute(
                              "data-sidebar",
                              "light"
                          ))
                        : "dark" == sessionStorage.getItem("data-sidebar")
                        ? (sessionStorage.setItem("data-sidebar", "dark"),
                          T("data-sidebar", "dark"),
                          document.documentElement.setAttribute(
                              "data-sidebar",
                              "dark"
                          ))
                        : "gradient" == sessionStorage.getItem("data-sidebar")
                        ? (sessionStorage.setItem("data-sidebar", "gradient"),
                          T("data-sidebar", "gradient"),
                          document.documentElement.setAttribute(
                              "data-sidebar",
                              "gradient"
                          ))
                        : "gradient-2" == sessionStorage.getItem("data-sidebar")
                        ? (sessionStorage.setItem("data-sidebar", "gradient-2"),
                          T("data-sidebar", "gradient-2"),
                          document.documentElement.setAttribute(
                              "data-sidebar",
                              "gradient-2"
                          ))
                        : "gradient-3" == sessionStorage.getItem("data-sidebar")
                        ? (sessionStorage.setItem("data-sidebar", "gradient-3"),
                          T("data-sidebar", "gradient-3"),
                          document.documentElement.setAttribute(
                              "data-sidebar",
                              "gradient-3"
                          ))
                        : "gradient-4" ==
                              sessionStorage.getItem("data-sidebar") &&
                          (sessionStorage.setItem("data-sidebar", "gradient-4"),
                          T("data-sidebar", "gradient-4"),
                          document.documentElement.setAttribute(
                              "data-sidebar",
                              "gradient-4"
                          ));
            }
            switch (e["data-sidebar-image"]) {
                case "none":
                    T("data-sidebar-image", "none"),
                        sessionStorage.setItem("data-sidebar-image", "none"),
                        document.documentElement.setAttribute(
                            "data-sidebar-image",
                            "none"
                        );
                    break;
                case "img-1":
                    T("data-sidebar-image", "img-1"),
                        sessionStorage.setItem("data-sidebar-image", "img-1"),
                        document.documentElement.setAttribute(
                            "data-sidebar-image",
                            "img-1"
                        );
                    break;
                case "img-2":
                    T("data-sidebar-image", "img-2"),
                        sessionStorage.setItem("data-sidebar-image", "img-2"),
                        document.documentElement.setAttribute(
                            "data-sidebar-image",
                            "img-2"
                        );
                    break;
                case "img-3":
                    T("data-sidebar-image", "img-3"),
                        sessionStorage.setItem("data-sidebar-image", "img-3"),
                        document.documentElement.setAttribute(
                            "data-sidebar-image",
                            "img-3"
                        );
                    break;
                case "img-4":
                    T("data-sidebar-image", "img-4"),
                        sessionStorage.setItem("data-sidebar-image", "img-4"),
                        document.documentElement.setAttribute(
                            "data-sidebar-image",
                            "img-4"
                        );
                    break;
                default:
                    sessionStorage.getItem("data-sidebar-image") &&
                    "none" == sessionStorage.getItem("data-sidebar-image")
                        ? (sessionStorage.setItem("data-sidebar-image", "none"),
                          T("data-sidebar-image", "none"),
                          document.documentElement.setAttribute(
                              "data-sidebar-image",
                              "none"
                          ))
                        : "img-1" ==
                          sessionStorage.getItem("data-sidebar-image")
                        ? (sessionStorage.setItem(
                              "data-sidebar-image",
                              "img-1"
                          ),
                          T("data-sidebar-image", "img-1"),
                          document.documentElement.setAttribute(
                              "data-sidebar-image",
                              "img-2"
                          ))
                        : "img-2" ==
                          sessionStorage.getItem("data-sidebar-image")
                        ? (sessionStorage.setItem(
                              "data-sidebar-image",
                              "img-2"
                          ),
                          T("data-sidebar-image", "img-2"),
                          document.documentElement.setAttribute(
                              "data-sidebar-image",
                              "img-2"
                          ))
                        : "img-3" ==
                          sessionStorage.getItem("data-sidebar-image")
                        ? (sessionStorage.setItem(
                              "data-sidebar-image",
                              "img-3"
                          ),
                          T("data-sidebar-image", "img-3"),
                          document.documentElement.setAttribute(
                              "data-sidebar-image",
                              "img-3"
                          ))
                        : "img-4" ==
                              sessionStorage.getItem("data-sidebar-image") &&
                          (sessionStorage.setItem(
                              "data-sidebar-image",
                              "img-4"
                          ),
                          T("data-sidebar-image", "img-4"),
                          document.documentElement.setAttribute(
                              "data-sidebar-image",
                              "img-4"
                          ));
            }
            switch (e["data-layout-position"]) {
                case "fixed":
                    T("data-layout-position", "fixed"),
                        sessionStorage.setItem("data-layout-position", "fixed"),
                        document.documentElement.setAttribute(
                            "data-layout-position",
                            "fixed"
                        );
                    break;
                case "scrollable":
                    T("data-layout-position", "scrollable"),
                        sessionStorage.setItem(
                            "data-layout-position",
                            "scrollable"
                        ),
                        document.documentElement.setAttribute(
                            "data-layout-position",
                            "scrollable"
                        );
                    break;
                default:
                    sessionStorage.getItem("data-layout-position") &&
                    "scrollable" ==
                        sessionStorage.getItem("data-layout-position")
                        ? (T("data-layout-position", "scrollable"),
                          sessionStorage.setItem(
                              "data-layout-position",
                              "scrollable"
                          ),
                          document.documentElement.setAttribute(
                              "data-layout-position",
                              "scrollable"
                          ))
                        : (T("data-layout-position", "fixed"),
                          sessionStorage.setItem(
                              "data-layout-position",
                              "fixed"
                          ),
                          document.documentElement.setAttribute(
                              "data-layout-position",
                              "fixed"
                          ));
            }
            switch (e["data-preloader"]) {
                case "disable":
                    T("data-preloader", "disable"),
                        sessionStorage.setItem("data-preloader", "disable"),
                        document.documentElement.setAttribute(
                            "data-preloader",
                            "disable"
                        );
                    break;
                case "enable":
                    T("data-preloader", "enable"),
                        sessionStorage.setItem("data-preloader", "enable"),
                        document.documentElement.setAttribute(
                            "data-preloader",
                            "enable"
                        ),
                        (t = document.getElementById("preloader")) &&
                            window.addEventListener("load", function () {
                                (t.style.opacity = "0"),
                                    (t.style.visibility = "hidden");
                            });
                    break;
                default:
                    var t;
                    sessionStorage.getItem("data-preloader") &&
                    "disable" == sessionStorage.getItem("data-preloader")
                        ? (T("data-preloader", "disable"),
                          sessionStorage.setItem("data-preloader", "disable"),
                          document.documentElement.setAttribute(
                              "data-preloader",
                              "disable"
                          ))
                        : "enable" == sessionStorage.getItem("data-preloader")
                        ? (T("data-preloader", "enable"),
                          sessionStorage.setItem("data-preloader", "enable"),
                          document.documentElement.setAttribute(
                              "data-preloader",
                              "enable"
                          ),
                          (t = document.getElementById("preloader")) &&
                              window.addEventListener("load", function () {
                                  (t.style.opacity = "0"),
                                      (t.style.visibility = "hidden");
                              }))
                        : document.documentElement.setAttribute(
                              "data-preloader",
                              "disable"
                          );
            }
            switch (e["data-body-image"]) {
                case "img-1":
                    T("data-body-image", "img-1"),
                        sessionStorage.setItem(
                            "data-sidebabodyr-image",
                            "img-1"
                        ),
                        document.documentElement.setAttribute(
                            "data-body-image",
                            "img-1"
                        ),
                        document.getElementById("theme-settings-offcanvas") &&
                            document.documentElement.removeAttribute(
                                "data-sidebar-image"
                            );
                    break;
                case "img-2":
                    T("data-body-image", "img-2"),
                        sessionStorage.setItem("data-body-image", "img-2"),
                        document.documentElement.setAttribute(
                            "data-body-image",
                            "img-2"
                        );
                    break;
                case "img-3":
                    T("data-body-image", "img-3"),
                        sessionStorage.setItem("data-body-image", "img-3"),
                        document.documentElement.setAttribute(
                            "data-body-image",
                            "img-3"
                        );
                    break;
                case "none":
                    T("data-body-image", "none"),
                        sessionStorage.setItem("data-body-image", "none"),
                        document.documentElement.setAttribute(
                            "data-body-image",
                            "none"
                        );
                    break;
                default:
                    sessionStorage.getItem("data-body-image") &&
                    "img-1" == sessionStorage.getItem("data-body-image")
                        ? (sessionStorage.setItem("data-body-image", "img-1"),
                          T("data-body-image", "img-1"),
                          document.documentElement.setAttribute(
                              "data-body-image",
                              "img-1"
                          ),
                          document.getElementById("theme-settings-offcanvas") &&
                              document.getElementById("sidebar-img") &&
                              ((document.getElementById(
                                  "sidebar-img"
                              ).style.display = "none"),
                              document.documentElement.removeAttribute(
                                  "data-sidebar-image"
                              )))
                        : "img-2" == sessionStorage.getItem("data-body-image")
                        ? (sessionStorage.setItem("data-body-image", "img-2"),
                          T("data-body-image", "img-2"),
                          document.documentElement.setAttribute(
                              "data-body-image",
                              "img-2"
                          ))
                        : "img-3" == sessionStorage.getItem("data-body-image")
                        ? (sessionStorage.setItem("data-body-image", "img-3"),
                          T("data-body-image", "img-3"),
                          document.documentElement.setAttribute(
                              "data-body-image",
                              "img-3"
                          ))
                        : "none" == sessionStorage.getItem("data-body-image") &&
                          (sessionStorage.setItem("data-body-image", "none"),
                          T("data-body-image", "none"),
                          document.documentElement.setAttribute(
                              "data-body-image",
                              "none"
                          ));
            }
        }
    }
    function p() {
        setTimeout(function () {
            var e,
                t,
                a = document.getElementById("navbar-nav");
            a &&
                ((a = a.querySelector(".nav-item .active")),
                300 < (e = a ? a.offsetTop : 0)) &&
                (t = document.getElementsByClassName("app-menu")
                    ? document.getElementsByClassName("app-menu")[0]
                    : "") &&
                t.querySelector(".simplebar-content-wrapper") &&
                setTimeout(function () {
                    t.querySelector(".simplebar-content-wrapper").scrollTop =
                        330 == e ? e + 85 : e;
                }, 0);
        }, 250);
    }
    var f,
        h,
        v,
        I,
        S,
        w,
        A,
        L,
        B,
        k,
        z,
        q,
        x = new Event("resize");
    function T(n, e) {
        Array.from(document.querySelectorAll("input[name=" + n + "]")).forEach(
            function (a) {
                e == a.value ? (a.checked = !0) : (a.checked = !1),
                    a.addEventListener("change", function () {
                        document.documentElement.setAttribute(n, a.value),
                            sessionStorage.setItem(n, a.value),
                            o(),
                            "data-layout-width" == n && "boxed" == a.value
                                ? (document.documentElement.setAttribute(
                                      "data-sidebar-size",
                                      "sm-hover"
                                  ),
                                  sessionStorage.setItem(
                                      "data-sidebar-size",
                                      "sm-hover"
                                  ),
                                  (document.getElementById(
                                      "sidebar-size-small-hover"
                                  ).checked = !0))
                                : "data-layout-width" == n &&
                                  "fluid" == a.value &&
                                  (document.documentElement.setAttribute(
                                      "data-sidebar-size",
                                      "lg"
                                  ),
                                  sessionStorage.setItem(
                                      "data-sidebar-size",
                                      "lg"
                                  ),
                                  (document.getElementById(
                                      "sidebar-size-default"
                                  ).checked = !0)),
                            "data-layout" == n &&
                                ("vertical" == a.value
                                    ? (y("vertical"), s(), feather.replace())
                                    : "horizontal" == a.value
                                    ? (document.getElementById(
                                          "sidebarimg-none"
                                      ) &&
                                          document
                                              .getElementById("sidebarimg-none")
                                              .click(),
                                      y("horizontal"),
                                      feather.replace())
                                    : "twocolumn" == a.value
                                    ? (y("twocolumn"),
                                      document.documentElement.setAttribute(
                                          "data-layout-width",
                                          "fluid"
                                      ),
                                      document
                                          .getElementById("layout-width-fluid")
                                          .click(),
                                      i(),
                                      u(),
                                      s(),
                                      feather.replace())
                                    : "semibox" == a.value &&
                                      (y("semibox"),
                                      document.documentElement.setAttribute(
                                          "data-layout-width",
                                          "fluid"
                                      ),
                                      document
                                          .getElementById("layout-width-fluid")
                                          .click(),
                                      document.documentElement.setAttribute(
                                          "data-layout-style",
                                          "default"
                                      ),
                                      document
                                          .getElementById(
                                              "sidebar-view-default"
                                          )
                                          .click(),
                                      s(),
                                      feather.replace()));
                        var e,
                            t = "block";
                        "semibox" ==
                            document.documentElement.getAttribute(
                                "data-layout"
                            ) &&
                            ("hidden" ==
                            document.documentElement.getAttribute(
                                "data-sidebar-visibility"
                            )
                                ? (document.documentElement.removeAttribute(
                                      "data-sidebar"
                                  ),
                                  document.documentElement.removeAttribute(
                                      "data-sidebar-image"
                                  ),
                                  document.documentElement.removeAttribute(
                                      "data-sidebar-size"
                                  ),
                                  (t = "none"))
                                : (document.documentElement.setAttribute(
                                      "data-sidebar",
                                      sessionStorage.getItem("data-sidebar")
                                  ),
                                  document.documentElement.setAttribute(
                                      "data-sidebar-image",
                                      sessionStorage.getItem(
                                          "data-sidebar-image"
                                      )
                                  ),
                                  document.documentElement.setAttribute(
                                      "data-sidebar-size",
                                      sessionStorage.getItem(
                                          "data-sidebar-size"
                                      )
                                  ))),
                            (document.getElementById(
                                "sidebar-size"
                            ).style.display = t),
                            (document.getElementById(
                                "sidebar-color"
                            ).style.display = t),
                            document.getElementById("sidebar-img") &&
                                (document.getElementById(
                                    "sidebar-img"
                                ).style.display = t),
                            "data-preloader" == n && "enable" == a.value
                                ? (document.documentElement.setAttribute(
                                      "data-preloader",
                                      "enable"
                                  ),
                                  (e = document.getElementById("preloader")) &&
                                      setTimeout(function () {
                                          (e.style.opacity = "0"),
                                              (e.style.visibility = "hidden");
                                      }, 1e3),
                                  document
                                      .getElementById("customizerclose-btn")
                                      .click())
                                : "data-preloader" == n &&
                                  "disable" == a.value &&
                                  (document.documentElement.setAttribute(
                                      "data-preloader",
                                      "disable"
                                  ),
                                  document
                                      .getElementById("customizerclose-btn")
                                      .click()),
                            "data-bs-theme" == n && window.dispatchEvent(x);
                    });
            }
        ),
            document.getElementById("collapseBgGradient") &&
                Array.from(
                    document.querySelectorAll(
                        "#collapseBgGradient .form-check input"
                    )
                ).forEach(function (e) {
                    var t = document.getElementById("collapseBgGradient");
                    1 == e.checked &&
                        new bootstrap.Collapse(t, { toggle: !1 }).show(),
                        document.querySelector(
                            "[data-bs-target='#collapseBgGradient']"
                        ) &&
                            document
                                .querySelector(
                                    "[data-bs-target='#collapseBgGradient']"
                                )
                                .addEventListener("click", function (e) {
                                    document
                                        .getElementById(
                                            "sidebar-color-gradient"
                                        )
                                        .click();
                                });
                }),
            document.querySelectorAll(
                "[data-bs-target='#collapseBgGradient.show']"
            ) &&
                Array.from(
                    document.querySelectorAll(
                        "[data-bs-target='#collapseBgGradient.show']"
                    )
                ).forEach(function (e) {
                    e.addEventListener("click", function () {
                        var e = document.getElementById("collapseBgGradient");
                        new bootstrap.Collapse(e, { toggle: !1 }).hide();
                    });
                }),
            Array.from(
                document.querySelectorAll("[name='data-sidebar']")
            ).forEach(function (e) {
                document.querySelector(
                    "[data-bs-target='#collapseBgGradient']"
                ) &&
                    (document.querySelector(
                        "#collapseBgGradient .form-check input:checked"
                    )
                        ? document
                              .querySelector(
                                  "[data-bs-target='#collapseBgGradient']"
                              )
                              .classList.add("active")
                        : document
                              .querySelector(
                                  "[data-bs-target='#collapseBgGradient']"
                              )
                              .classList.remove("active"),
                    e.addEventListener("change", function () {
                        document.querySelector(
                            "#collapseBgGradient .form-check input:checked"
                        )
                            ? document
                                  .querySelector(
                                      "[data-bs-target='#collapseBgGradient']"
                                  )
                                  .classList.add("active")
                            : document
                                  .querySelector(
                                      "[data-bs-target='#collapseBgGradient']"
                                  )
                                  .classList.remove("active");
                    }));
            });
    }
    function C(e, t, a, n) {
        var o = document.getElementById(a);
        n.setAttribute(e, t), o && document.getElementById(a).click();
    }
    function N() {
        document.webkitIsFullScreen ||
            document.mozFullScreen ||
            document.msFullscreenElement ||
            document.body.classList.remove("fullscreen-enable");
    }
    function F() {
        var t = 0;
        Array.from(document.getElementsByClassName("cart-item-price")).forEach(
            function (e) {
                t += parseFloat(e.innerHTML);
            }
        ),
            document.getElementById("cart-item-total") &&
                (document.getElementById("cart-item-total").innerHTML =
                    "$" + t.toFixed(2));
    }
    function H() {
        Array.from(
            document.querySelectorAll("#notificationItemsTabContent .tab-pane")
        ).forEach(function (e) {
            0 < e.querySelectorAll(".notification-item").length
                ? e.querySelector(".view-all") &&
                  (e.querySelector(".view-all").style.display = "block")
                : (e.querySelector(".view-all") &&
                      (e.querySelector(".view-all").style.display = "none"),
                  e.querySelector(".empty-notification-elem") ||
                      (e.innerHTML +=
                          '<div class="empty-notification-elem">\t\t\t\t\t\t\t' +
                          '<div class="w-25 w-sm-50 pt-3 mx-auto">\t\t\t\t\t\t\t\t' + 
                          `<img src="${PATH_ROOT}/assets/images/svg/bell.svg" class="img-fluid" alt="user-pic">\t\t\t\t\t\t\t` + 
                          '</div>\t\t\t\t\t\t\t<div class="text-center pb-5 mt-2">\t\t\t\t\t\t\t\t<h6 class="fs-18 fw-semibold lh-base">Hey! You have no any notifications </h6>\t\t\t\t\t\t\t</div>\t\t\t\t\t\t</div>'));
        });
    }
    function W() {
        var e;
        "horizontal" !== document.documentElement.getAttribute("data-layout") &&
            (document.getElementById("navbar-nav") &&
                (e = new SimpleBar(document.getElementById("navbar-nav"))) &&
                e.getContentElement(),
            document.getElementsByClassName("twocolumn-iconview")[0] &&
                (e = new SimpleBar(
                    document.getElementsByClassName("twocolumn-iconview")[0]
                )) &&
                e.getContentElement(),
            clearTimeout(q));
    }
    sessionStorage.getItem("defaultAttribute")
        ? (((f = {})["data-layout"] = sessionStorage.getItem("data-layout")),
          (f["data-sidebar-size"] =
              sessionStorage.getItem("data-sidebar-size")),
          (f["data-bs-theme"] = sessionStorage.getItem("data-bs-theme")),
          (f["data-layout-width"] =
              sessionStorage.getItem("data-layout-width")),
          (f["data-sidebar"] = sessionStorage.getItem("data-sidebar")),
          (f["data-sidebar-image"] =
              sessionStorage.getItem("data-sidebar-image")),
          (f["data-layout-position"] = sessionStorage.getItem(
              "data-layout-position"
          )),
          (f["data-layout-style"] =
              sessionStorage.getItem("data-layout-style")),
          (f["data-topbar"] = sessionStorage.getItem("data-topbar")),
          (f["data-preloader"] = sessionStorage.getItem("data-preloader")),
          (f["data-body-image"] = sessionStorage.getItem("data-body-image")),
          e(f))
        : ((L = document.documentElement.attributes),
          (f = {}),
          Array.from(L).forEach(function (e) {
              var t;
              e &&
                  e.nodeName &&
                  "undefined" != e.nodeName &&
                  ((t = e.nodeName),
                  (f[t] = e.nodeValue),
                  sessionStorage.setItem(t, e.nodeValue));
          }),
          sessionStorage.setItem("defaultAttribute", JSON.stringify(f)),
          e(f),
          (L = document.querySelector(
              '.btn[data-bs-target="#theme-settings-offcanvas"]'
          )) && L.click()),
        i(),
        (h = document.getElementById("search-close-options")),
        (v = document.getElementById("search-dropdown")),
        (I = document.getElementById("search-options")) &&
            (I.addEventListener("focus", function () {
                0 < I.value.length
                    ? (v.classList.add("show"), h.classList.remove("d-none"))
                    : (v.classList.remove("show"), h.classList.add("d-none"));
            }),
            I.addEventListener("keyup", function (e) {
                var o, t;
                0 < I.value.length
                    ? (v.classList.add("show"),
                      h.classList.remove("d-none"),
                      (o = I.value.toLowerCase()),
                      (t = document.getElementsByClassName("notify-item")),
                      Array.from(t).forEach(function (e) {
                          var t,
                              a,
                              n = "";
                          e.querySelector("h6")
                              ? ((t = e
                                    .getElementsByTagName("span")[0]
                                    .innerText.toLowerCase()),
                                (n = (a = e
                                    .querySelector("h6")
                                    .innerText.toLowerCase()).includes(o)
                                    ? a
                                    : t))
                              : e.getElementsByTagName("span") &&
                                (n = e
                                    .getElementsByTagName("span")[0]
                                    .innerText.toLowerCase()),
                              n &&
                                  (e.style.display = n.includes(o)
                                      ? "block"
                                      : "none");
                      }))
                    : (v.classList.remove("show"), h.classList.add("d-none"));
            }),
            h.addEventListener("click", function () {
                (I.value = ""),
                    v.classList.remove("show"),
                    h.classList.add("d-none");
            }),
            document.body.addEventListener("click", function (e) {
                "search-options" !== e.target.getAttribute("id") &&
                    (v.classList.remove("show"), h.classList.add("d-none"));
            })),
        (S = document.getElementById("search-close-options")),
        (w = document.getElementById("search-dropdown-reponsive")),
        (A = document.getElementById("search-options-reponsive")),
        S &&
            w &&
            A &&
            (A.addEventListener("focus", function () {
                0 < A.value.length
                    ? (w.classList.add("show"), S.classList.remove("d-none"))
                    : (w.classList.remove("show"), S.classList.add("d-none"));
            }),
            A.addEventListener("keyup", function () {
                0 < A.value.length
                    ? (w.classList.add("show"), S.classList.remove("d-none"))
                    : (w.classList.remove("show"), S.classList.add("d-none"));
            }),
            S.addEventListener("click", function () {
                (A.value = ""),
                    w.classList.remove("show"),
                    S.classList.add("d-none");
            }),
            document.body.addEventListener("click", function (e) {
                "search-options" !== e.target.getAttribute("id") &&
                    (w.classList.remove("show"), S.classList.add("d-none"));
            })),
        (L = document.querySelector('[data-toggle="fullscreen"]')) &&
            L.addEventListener("click", function (e) {
                e.preventDefault(),
                    document.body.classList.toggle("fullscreen-enable"),
                    document.fullscreenElement ||
                    document.mozFullScreenElement ||
                    document.webkitFullscreenElement
                        ? document.cancelFullScreen
                            ? document.cancelFullScreen()
                            : document.mozCancelFullScreen
                            ? document.mozCancelFullScreen()
                            : document.webkitCancelFullScreen &&
                              document.webkitCancelFullScreen()
                        : document.documentElement.requestFullscreen
                        ? document.documentElement.requestFullscreen()
                        : document.documentElement.mozRequestFullScreen
                        ? document.documentElement.mozRequestFullScreen()
                        : document.documentElement.webkitRequestFullscreen &&
                          document.documentElement.webkitRequestFullscreen(
                              Element.ALLOW_KEYBOARD_INPUT
                          );
            }),
        document.addEventListener("fullscreenchange", N),
        document.addEventListener("webkitfullscreenchange", N),
        document.addEventListener("mozfullscreenchange", N),
        (B = document.getElementsByTagName("HTML")[0]),
        (z = document.querySelectorAll(".light-dark-mode")) &&
            z.length &&
            z[0].addEventListener("click", function (e) {
                B.hasAttribute("data-bs-theme") &&
                "dark" == B.getAttribute("data-bs-theme")
                    ? C("data-bs-theme", "light", "layout-mode-light", B)
                    : C("data-bs-theme", "dark", "layout-mode-dark", B),
                    window.dispatchEvent(x);
            }),
        G(),
        D(),
        r(),
        document.getElementsByClassName("dropdown-item-cart") &&
            ((k = document.querySelectorAll(".dropdown-item-cart").length),
            Array.from(
                document.querySelectorAll(
                    "#page-topbar .dropdown-menu-cart .remove-item-btn"
                )
            ).forEach(function (e) {
                e.addEventListener("click", function (e) {
                    k--,
                        this.closest(".dropdown-item-cart").remove(),
                        Array.from(
                            document.getElementsByClassName("cartitem-badge")
                        ).forEach(function (e) {
                            e.innerHTML = k;
                        }),
                        F(),
                        document.getElementById("empty-cart") &&
                            (document.getElementById(
                                "empty-cart"
                            ).style.display = 0 == k ? "block" : "none"),
                        document.getElementById("checkout-elem") &&
                            (document.getElementById(
                                "checkout-elem"
                            ).style.display = 0 == k ? "none" : "block");
                });
            }),
            Array.from(
                document.getElementsByClassName("cartitem-badge")
            ).forEach(function (e) {
                e.innerHTML = k;
            }),
            document.getElementById("empty-cart") &&
                (document.getElementById("empty-cart").style.display = "none"),
            document.getElementById("checkout-elem") &&
                (document.getElementById("checkout-elem").style.display =
                    "block"),
            F()),
        document.getElementsByClassName("notification-check") &&
            (H(),
            Array.from(
                document.querySelectorAll(".notification-check input")
            ).forEach(function (t) {
                t.addEventListener("change", function (e) {
                    e.target
                        .closest(".notification-item")
                        .classList.toggle("active");
                    var t = document.querySelectorAll(
                        ".notification-check input:checked"
                    ).length;
                    e.target
                        .closest(".notification-item")
                        .classList.contains("active"),
                        (document.getElementById(
                            "notification-actions"
                        ).style.display = 0 < t ? "block" : "none"),
                        (document.getElementById("select-content").innerHTML =
                            t);
                }),
                    document
                        .getElementById("notificationDropdown")
                        .addEventListener("hide.bs.dropdown", function (e) {
                            (t.checked = !1),
                                document
                                    .querySelectorAll(".notification-item")
                                    .forEach(function (e) {
                                        e.classList.remove("active");
                                    }),
                                (document.getElementById(
                                    "notification-actions"
                                ).style.display = "");
                        });
            }),
            document
                .getElementById("removeNotificationModal")
                .addEventListener("show.bs.modal", function (e) {
                    document
                        .getElementById("delete-notification")
                        .addEventListener("click", function () {
                            Array.from(
                                document.querySelectorAll(".notification-item")
                            ).forEach(function (e) {
                                e.classList.contains("active") && e.remove();
                            }),
                                H(),
                                document
                                    .getElementById(
                                        "NotificationModalbtn-close"
                                    )
                                    .click();
                        });
                })),
        [].slice
            .call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            .map(function (e) {
                return new bootstrap.Tooltip(e);
            }),
        [].slice
            .call(document.querySelectorAll('[data-bs-toggle="popover"]'))
            .map(function (e) {
                return new bootstrap.Popover(e);
            }),
        document.getElementById("reset-layout") &&
            document
                .getElementById("reset-layout")
                .addEventListener("click", function () {
                    sessionStorage.clear(), window.location.reload();
                }),
        (z = document.querySelectorAll("[data-toast]")),
        Array.from(z).forEach(function (a) {
            a.addEventListener("click", function () {
                var e = {},
                    t = a.attributes;
                t["data-toast-text"] &&
                    (e.text = t["data-toast-text"].value.toString()),
                    t["data-toast-gravity"] &&
                        (e.gravity = t["data-toast-gravity"].value.toString()),
                    t["data-toast-position"] &&
                        (e.position =
                            t["data-toast-position"].value.toString()),
                    t["data-toast-className"] &&
                        (e.className =
                            t["data-toast-className"].value.toString()),
                    t["data-toast-duration"] &&
                        (e.duration =
                            t["data-toast-duration"].value.toString()),
                    t["data-toast-close"] &&
                        (e.close = t["data-toast-close"].value.toString()),
                    t["data-toast-style"] &&
                        (e.style = t["data-toast-style"].value.toString()),
                    t["data-toast-offset"] &&
                        (e.offset = t["data-toast-offset"]),
                    Toastify({
                        newWindow: !0,
                        text: e.text,
                        gravity: e.gravity,
                        position: e.position,
                        className: "bg-" + e.className,
                        stopOnFocus: !0,
                        offset: { x: e.offset ? 50 : 0, y: e.offset ? 10 : 0 },
                        duration: e.duration,
                        close: "close" == e.close,
                        style:
                            "style" == e.style
                                ? {
                                      background:
                                          "linear-gradient(to right, #0AB39C, #405189)",
                                  }
                                : "",
                    }).showToast();
            });
        }),
        (z = document.querySelectorAll("[data-choices]")),
        Array.from(z).forEach(function (e) {
            var t = {},
                a = e.attributes;
            a["data-choices-groups"] &&
                (t.placeholderValue =
                    "This is a placeholder set in the config"),
                a["data-choices-search-false"] && (t.searchEnabled = !1),
                a["data-choices-search-true"] && (t.searchEnabled = !0),
                a["data-choices-removeItem"] && (t.removeItemButton = !0),
                a["data-choices-sorting-false"] && (t.shouldSort = !1),
                a["data-choices-sorting-true"] && (t.shouldSort = !0),
                a["data-choices-multiple-remove"] && (t.removeItemButton = !0),
                a["data-choices-limit"] &&
                    (t.maxItemCount = a["data-choices-limit"].value.toString()),
                a["data-choices-limit"] &&
                    (t.maxItemCount = a["data-choices-limit"].value.toString()),
                a["data-choices-editItem-true"] && (t.maxItemCount = !0),
                a["data-choices-editItem-false"] && (t.maxItemCount = !1),
                a["data-choices-text-unique-true"] &&
                    (t.duplicateItemsAllowed = !1),
                a["data-choices-text-disabled-true"] && (t.addItems = !1),
                a["data-choices-text-disabled-true"]
                    ? new Choices(e, t).disable()
                    : new Choices(e, t);
        }),
        (z = document.querySelectorAll("[data-provider]")),
        Array.from(z).forEach(function (e) {
            var t, a, n;
            "flatpickr" == e.getAttribute("data-provider")
                ? ((n = e.attributes),
                  ((t = {}).disableMobile = "true"),
                  n["data-date-format"] &&
                      (t.dateFormat = n["data-date-format"].value.toString()),
                  n["data-enable-time"] &&
                      ((t.enableTime = !0),
                      (t.dateFormat =
                          n["data-date-format"].value.toString() + " H:i")),
                  n["data-altFormat"] &&
                      ((t.altInput = !0),
                      (t.altFormat = n["data-altFormat"].value.toString())),
                  n["data-minDate"] &&
                      ((t.minDate = n["data-minDate"].value.toString()),
                      (t.dateFormat = n["data-date-format"].value.toString())),
                  n["data-maxDate"] &&
                      ((t.maxDate = n["data-maxDate"].value.toString()),
                      (t.dateFormat = n["data-date-format"].value.toString())),
                  n["data-deafult-date"] &&
                      ((t.defaultDate =
                          n["data-deafult-date"].value.toString()),
                      (t.dateFormat = n["data-date-format"].value.toString())),
                  n["data-multiple-date"] &&
                      ((t.mode = "multiple"),
                      (t.dateFormat = n["data-date-format"].value.toString())),
                  n["data-range-date"] &&
                      ((t.mode = "range"),
                      (t.dateFormat = n["data-date-format"].value.toString())),
                  n["data-inline-date"] &&
                      ((t.inline = !0),
                      (t.defaultDate = n["data-deafult-date"].value.toString()),
                      (t.dateFormat = n["data-date-format"].value.toString())),
                  n["data-disable-date"] &&
                      ((a = []).push(n["data-disable-date"].value),
                      (t.disable = a.toString().split(","))),
                  n["data-week-number"] &&
                      ((a = []).push(n["data-week-number"].value),
                      (t.weekNumbers = !0)),
                  flatpickr(e, t))
                : "timepickr" == e.getAttribute("data-provider") &&
                  ((a = {}),
                  (n = e.attributes)["data-time-basic"] &&
                      ((a.enableTime = !0),
                      (a.noCalendar = !0),
                      (a.dateFormat = "H:i")),
                  n["data-time-hrs"] &&
                      ((a.enableTime = !0),
                      (a.noCalendar = !0),
                      (a.dateFormat = "H:i"),
                      (a.time_24hr = !0)),
                  n["data-min-time"] &&
                      ((a.enableTime = !0),
                      (a.noCalendar = !0),
                      (a.dateFormat = "H:i"),
                      (a.minTime = n["data-min-time"].value.toString())),
                  n["data-max-time"] &&
                      ((a.enableTime = !0),
                      (a.noCalendar = !0),
                      (a.dateFormat = "H:i"),
                      (a.minTime = n["data-max-time"].value.toString())),
                  n["data-default-time"] &&
                      ((a.enableTime = !0),
                      (a.noCalendar = !0),
                      (a.dateFormat = "H:i"),
                      (a.defaultDate =
                          n["data-default-time"].value.toString())),
                  n["data-time-inline"] &&
                      ((a.enableTime = !0),
                      (a.noCalendar = !0),
                      (a.defaultDate = n["data-time-inline"].value.toString()),
                      (a.inline = !0)),
                  flatpickr(e, a));
        }),
        Array.from(
            document.querySelectorAll('.dropdown-menu a[data-bs-toggle="tab"]')
        ).forEach(function (e) {
            e.addEventListener("click", function (e) {
                e.stopPropagation(), bootstrap.Tab.getInstance(e.target).show();
            });
        }),
        o(),
        s(),
        p(),
        window.addEventListener("resize", function () {
            q && clearTimeout(q), (q = setTimeout(W, 2e3));
        });
})();
var mybutton = document.getElementById("back-to-top");
function scrollFunction() {
    100 < document.body.scrollTop || 100 < document.documentElement.scrollTop
        ? (mybutton.style.display = "block")
        : (mybutton.style.display = "none");
}
function topFunction() {
    (document.body.scrollTop = 0), (document.documentElement.scrollTop = 0);
}
mybutton &&
    (window.onscroll = function () {
        scrollFunction();
    });
