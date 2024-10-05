import React, { Fragment, useState } from "react";
import { InputGroup } from "reactstrap";
import { faCalendarAlt } from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import DatePicker from "react-datepicker";

function FormDatePicker4() {
  const [startDate, setStartDate] = useState(new Date());

  const handleChange = (date) => {
    setStartDate(date);
  };

  return (
    <Fragment>
      <InputGroup>
        <div className="input-group-text">
          <FontAwesomeIcon icon={faCalendarAlt} />
        </div>
        <DatePicker
          selected={startDate}
          onChange={handleChange}
          placeholderText="Click to select a date"
          className="form-control"
        />
      </InputGroup>
    </Fragment>
  );
}

export default FormDatePicker4;
