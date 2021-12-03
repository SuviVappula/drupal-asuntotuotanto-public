#ASU - REST

Custom module which extends core REST module.

# ENDPOINTS

## Initialize

```
Example:

Parameters:
None

returns:
{
  user: {
     id: Number
     email: String
     username: String
     applications: Array - project id: [array of apartment ids]
     {
       3: [12,10,18,22,23],
       22: [31,55,56,77,88]
       ...
     }
  },
  static_content: {
    hitas_instruction_text: "text goes here"
    hitas_instruction_text_mobile: "text goes here"
    hitas_instruction_icon_text: "text goes here"
    hitas_instruction_url: "text goes here"
  },
  filters: Array: {
    "elastic_index_field_name": {
      "label": "Title for the filter",
      "items": ["First value to use as a filter", "Second value to use as a filter", ...],
      "suffix": NULL
    },
    "living_area": {
      "label": "Pinta-ala / m2",
      "items": ["Enintään", "Vähintään2],
      "suffix": "m2"
    }, ...
  },
  application_status: Array - project id: [application id: enum, ... ]
  [
    2: [5: HIGH, 6: MEDIUM, 7:LOW],
    7: [99: LOW, 104: HIGH, ...],
    ...
  ]
}

```
