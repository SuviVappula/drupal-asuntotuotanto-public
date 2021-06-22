(($, Drupal) => {
  Drupal.behaviors.applicationFormActions = {
    attach: function attach() {
      const applicationFormApartmentListElement = document.getElementById(
        "application_form_apartments_list"
      );

      const createParagraphElementWithVisuallyHiddenText = (
        classes,
        hiddenTextString,
        visibleString
      ) => {
        const p = document.createElement("p");
        p.classList.add(...classes);

        const span1 = document.createElement("span");
        const span1Content = document.createTextNode(
          Drupal.t(hiddenTextString)
        );
        span1.classList.add("visually-hidden");
        span1.appendChild(span1Content);

        const span2 = document.createElement("span");
        const span2Content = document.createTextNode(visibleString);
        span2.appendChild(span2Content);

        p.append(span1, span2);

        return p;
      };

      const createButtonElement = (classes, content, disabled = false) => {
        const button = document.createElement("button");
        button.classList.add(...classes);
        const span = document.createElement("span");
        const text = document.createTextNode(Drupal.t(content));

        span.append(text);
        button.append(span);

        button.setAttribute("type", "button");

        if (disabled) button.disabled = true;

        return button;
      };

      const createListItemElementWithText = (description, value) => {
        const liElement = document.createElement("li");
        const span1 = document.createElement("span");
        const text1 = document.createTextNode(Drupal.t(description));
        span1.appendChild(text1);

        const span2 = document.createElement("span");
        const text2 = document.createTextNode(Drupal.t(value));
        span2.appendChild(text2);

        liElement.append(span1, span2);

        return liElement;
      };

      const createApartmentListItem = (withSelectElement = false) => {
        const li = document.createElement("li");
        li.classList.add(
          "application-form__apartments-item",
          withSelectElement &&
            '"application-form__apartments-item--with-select"'
        );

        const article = document.createElement("article");
        article.classList.add("application-form-apartment");

        const listPositionDesktop = createParagraphElementWithVisuallyHiddenText(
          ["application-form-apartment__list-position", "is-desktop"],
          "List position",
          "1"
        );

        const formHeader = document.createElement("div");
        formHeader.classList.add("application-form-apartment__header");

        const listPositionMobile = createParagraphElementWithVisuallyHiddenText(
          ["application-form-apartment__list-position", "is-mobile"],
          "List position",
          "1"
        );

        const apartmentNumber = createParagraphElementWithVisuallyHiddenText(
          ["application-form-apartment__apartment-number"],
          "Apartment",
          "A75"
        );

        const apartmentStructure = createParagraphElementWithVisuallyHiddenText(
          ["application-form-apartment__apartment-structure"],
          "Apartment structure",
          "4h, kt, s"
        );

        const apartmentAddButton = createButtonElement(
          ["application-form-apartment__apartment-add-button"],
          "Add an apartment to the list"
        );

        const apartmentListElementWrapper = document.createElement("div");
        apartmentListElementWrapper.classList.add(
          "application-form-apartment__apartment-add-actions-wrapper",
          "is-hidden"
        );

        const selectElementId = "apartment_list_select";

        const apartmentListElement = document.createElement("div");
        apartmentListElement.classList.add("hds-select-element");

        const apartmentSelectElementLabel = document.createElement("label");
        const apartmentSelectElementLabelText = document.createTextNode(
          Drupal.t("Apartment")
        );
        apartmentSelectElementLabel.appendChild(
          apartmentSelectElementLabelText
        );

        apartmentSelectElementLabel.setAttribute("for", selectElementId);

        const apartmentSelectElementWrapper = document.createElement("div");
        apartmentSelectElementWrapper.classList.add(
          "hds-select-element__select-wrapper"
        );

        const apartmentSelectElement = document.createElement("select");
        apartmentSelectElement.classList.add("hds-select-element__select");
        apartmentSelectElement.setAttribute("id", selectElementId);

        apartmentSelectElementWrapper.appendChild(apartmentSelectElement);

        apartmentListElement.append(
          apartmentSelectElementLabel,
          apartmentSelectElementWrapper
        );
        apartmentListElementWrapper.appendChild(apartmentListElement);

        if (withSelectElement) {
          formHeader.append(
            listPositionMobile,
            apartmentAddButton,
            apartmentListElementWrapper
          );
        } else {
          formHeader.append(
            listPositionMobile,
            apartmentNumber,
            apartmentStructure
          );
        }

        const listPositionActions = document.createElement("div");
        listPositionActions.classList.add(
          "application-form-apartment__list-position-actions"
        );

        const listPositionActionsRaiseButton = createButtonElement(
          "",
          "Raise on the list",
          withSelectElement && true
        );
        const listPositionActionsLowerButton = createButtonElement(
          "",
          "Lower on the list",
          withSelectElement && true
        );

        listPositionActions.append(
          listPositionActionsRaiseButton,
          listPositionActionsLowerButton
        );

        const formApartmentInformation = document.createElement("ul");
        formApartmentInformation.classList.add(
          "application-form-apartment__information"
        );

        const formApartmentInformationFloor = createListItemElementWithText(
          "Floor",
          "7/7"
        );

        const formApartmentInformationLivingAreaSize = createListItemElementWithText(
          "Living area size",
          "85,0 m2"
        );

        const formApartmentInformationSalesPrice = createListItemElementWithText(
          "Sales price",
          "308 128 €"
        );

        const formApartmentInformationDebtFreeSalesPrice = createListItemElementWithText(
          "Debt free sales price",
          "378 128 €"
        );

        formApartmentInformation.append(
          formApartmentInformationFloor,
          formApartmentInformationLivingAreaSize,
          formApartmentInformationSalesPrice,
          formApartmentInformationDebtFreeSalesPrice
        );

        const formActions = document.createElement("div");
        formActions.classList.add("application-form-apartment__actions");

        const formActionsDeleteButton = createButtonElement("", "Delete");

        const formActionsLink = document.createElement("a");
        const formActionsLinkText = document.createTextNode(
          Drupal.t("Open apartment page")
        );
        formActionsLink.appendChild(formActionsLinkText);
        formActionsLink.setAttribute("href", "https://google.fi");

        formActions.append(formActionsDeleteButton, formActionsLink);

        if (withSelectElement) {
          article.append(listPositionDesktop, formHeader, listPositionActions);
        } else {
          article.append(
            listPositionDesktop,
            formHeader,
            listPositionActions,
            formApartmentInformation,
            formActions
          );
        }

        return li.appendChild(article);
      };

      applicationFormApartmentListElement.append(
        createApartmentListItem(),
        createApartmentListItem(true)
      );
    },
  };
})(jQuery, Drupal);
