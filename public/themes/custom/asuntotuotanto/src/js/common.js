((Drupal) => {
  Drupal.behaviors.mobileMenuToggle = {
    attach: function attach() {
      const bodyElement = document.getElementsByTagName("body")[0];
      const headerBackgroundShadowElement = document.getElementsByClassName(
        "page-header__background-shadow"
      )[0];

      const mobileNavigationToggleButtonElement = document.getElementById(
        "mobile_navigation_toggle_button"
      );

      const mobileNavigationElement = document.getElementsByClassName(
        "page-header__bottom"
      )[0];

      const mobileSubmenuButtonElements = document.getElementsByClassName(
        "sub-menu__button"
      );

      const handleMobileNavigationClose = () => {
        mobileNavigationElement.setAttribute("aria-hidden", true);
        mobileNavigationToggleButtonElement.setAttribute(
          "aria-expanded",
          false
        );
        bodyElement.style.overflow = "visible";
        mobileNavigationElement.classList.add("is-hidden");
      };

      const handleMobileNavigationToggleClick = ({ target }) => {
        if (mobileNavigationElement.classList.contains("is-hidden")) {
          mobileNavigationElement.setAttribute("aria-hidden", false);
          target.setAttribute("aria-expanded", true);
          bodyElement.style.overflow = "hidden";
        } else {
          mobileNavigationElement.setAttribute("aria-hidden", true);
          target.setAttribute("aria-expanded", false);
          bodyElement.style.overflow = "visible";
        }

        mobileNavigationElement.classList.toggle("is-hidden");
      };

      const handleSubmenuToggleClick = ({ target }) => {
        [...mobileSubmenuButtonElements].forEach((element) => {
          if (element !== target) {
            element.parentElement.nextElementSibling.classList.add("is-hidden");
            element.parentElement.nextElementSibling.setAttribute(
              "aria-hidden",
              true
            );
            element.setAttribute("aria-expanded", false);
          }
        });

        const submenuElement = target.parentElement.nextElementSibling;

        if (target.getAttribute("aria-expanded") === "false") {
          submenuElement.classList.remove("is-hidden");
          submenuElement.setAttribute("aria-hidden", false);
          target.setAttribute("aria-expanded", true);
        } else {
          submenuElement.classList.add("is-hidden");
          submenuElement.setAttribute("aria-hidden", true);
          target.setAttribute("aria-expanded", false);
        }
      };

      mobileNavigationToggleButtonElement.addEventListener(
        "click",
        handleMobileNavigationToggleClick
      );

      headerBackgroundShadowElement.addEventListener(
        "click",
        handleMobileNavigationClose
      );

      if (mobileSubmenuButtonElements) {
        [...mobileSubmenuButtonElements].forEach((element) => {
          element.addEventListener("click", handleSubmenuToggleClick);
        });
      }
    },
  };
})(Drupal);
