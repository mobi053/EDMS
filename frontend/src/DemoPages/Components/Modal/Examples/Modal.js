import React, { useState, useCallback } from "react";
import { Button, Modal, ModalHeader, ModalBody, ModalFooter,Input } from "reactstrap";
import axios from "axios";
function ModalExample({modalOpen, setModalOpen, modalData, setModalData, mode ,fetchData, handleEdit}) {
  // console.log(">>>>>>>>",modalData);

  const toggle = useCallback(() => {
    setModalOpen(prevModal => !prevModal);
  }, [setModalOpen]);
  // Handle input change for editing data
  const handleInputChange = (e) => {
    const { name, value } = e.target;
    setModalData((prevData) => ({
      ...prevData,
      [name]: value, // Update the specific field
    }));
  };

  const handleSubmit = async () => {
    try {
      if (mode === "Add") {
        // Sending a POST request to the API to add a class
        await axios.post('http://127.0.0.1:8000/api/classes/store', modalData);
        // Call fetchData to refresh the class list
        fetchData();
        // Close the modal after successful submission
        toggle();
      } else if (mode === "Edit"){
        const id=modalData.id;
        // Sending a POST request to the API to add a class
        await axios.put(`http://127.0.0.1:8000/api/classes/update/${id}`, modalData);
        // Call fetchData to refresh the class list
        // handleEdit();
        fetchData();
        // Close the modal after successful submission
        toggle();
      }
      // You can also add handling for edit mode if needed
    } catch (error) {
      console.error("Error saving class:", error);
      // Optionally, show an error message to the user
      alert("Failed to save class. Please try again.");
    }
  };

  // console.log(modalData)
  return (
    <span className="d-inline-block mb-2 me-2">
   
      <Modal isOpen={modalOpen} toggle={toggle} className={'abc'}>
        <ModalHeader toggle={toggle}>          
          {mode === "View" ? "View Class" : mode === "Edit" ? "Edit Class" : "Add Class"}
        </ModalHeader>
        <ModalBody>
          {/* Input fields will be disabled when in view mode */}
          <Input type="text" placeholder="Title" name="name" value={modalData.name || ""} onChange={handleInputChange} disabled={mode === "View"} required={mode ==="Add"}/>
          <Input type="textarea" placeholder="Teacher In Charge" name="teacher_in_charge_name" value={modalData.teacher_in_charge_name || ""} onChange={handleInputChange} disabled={mode === "View"} className="mt-2" required={mode ==="Add"}/>
          {/* Status radio buttons */}
          <label className="mt-3">Status</label>
          <div>
            <label>
              <input
                type="radio"
                name="status"
                value="0"
                checked={modalData.status === "0" || modalData.status === 0}
                onChange={handleInputChange}
                disabled={mode === "View"} // Disable input in view mode
              />
              Enable
            </label>
            <label className="ms-3">
              <input
                type="radio"
                name="status"
                value="1"
                checked={modalData.status === "1" || modalData.status === 1}
                onChange={handleInputChange}
                disabled={mode === "View"} // Disable input in view mode
              />
              Disable
            </label>
          </div>
        </ModalBody>
        <ModalFooter>
        <Button color="link" onClick={toggle}>Cancel</Button>
          {mode !== "view" && (
            <Button color="primary" onClick={handleSubmit}>
              {mode === "edit" ? "Update" : "Save"}
            </Button>
          )}
        </ModalFooter>
      </Modal>
    </span>
  );
}
 
export default ModalExample;