import React, { useState, useCallback, useEffect } from "react";
import { Button, Modal, ModalHeader, ModalBody, ModalFooter, Input, Row, Col } from "reactstrap";
import axios from "axios";
import { toast } from "react-toastify";

function SectionModal({ modalOpen, setModalOpen, modalData, setModalData, mode, fetchData, handleEdit, currentPage }) {
  const modalPage = currentPage + 1;
  console.log(modalData.campuses, "<<<<<<<<<");
  // Fetch campuses when modal is opened (if needed)
  useEffect(() => {
    if (modalOpen && !modalData.campuses) {
      // Fetch campus list from API
      const fetchCampusList = async () => {
        try {
          // Fetch the campus list
          const response = await axios.get('http://127.0.0.1:8000/api/campuses/view_campuses', {
            params: { limit: "all" }
          });
              const campusList = response.data; // Assuming the response is directly the list
          // Set the campus list in the modal data
          setModalData({campuses: campusList});
        } catch (error) {
          console.error('Error Fetching Campus List:', error);
          setModalData({campuses: []});
        }
      };
      fetchCampusList();
    }
  }, [modalOpen, modalData.campuses, setModalData]);


  const toggle = useCallback(() => {
    setModalOpen(prevModal => !prevModal);
  }, [setModalOpen]);

  const handleInputChange = (e) => {
    const { name, value } = e.target;
    setModalData((prevData) => ({
      ...prevData,
      [name]: value,
    }));
  };

  const handleSubmit = async () => {
    if (!modalData.name) {
      return toast.error('Please enter Section Name');
    }
    // Additional input validation can go here

    try {
      if (mode === "Add") {
        await axios.post('http://127.0.0.1:8000/api/sections/store', modalData);
      } else if (mode === "Edit") {
        const id = modalData.id;
        await axios.put(`http://127.0.0.1:8000/api/sections/update/${id}`, modalData);
      }
      fetchData("", 10, modalPage);
      toggle();
      toast.success("Section saved successfully!");
    } catch (error) {
      toast.error("Failed to save section. Please try again.");
    }
  };

  return (
    <span className="d-inline-block mb-2 me-2">
      <Modal isOpen={modalOpen} toggle={toggle} size="lg">
        <ModalHeader toggle={toggle}>
          {mode === "View" ? "View Section" : mode === "Edit" ? "Edit Section" : "Add Section"}
        </ModalHeader>
        <ModalBody>
          <Row>
            <Col md={6}>
              <Input
                type="text"
                placeholder="Section Name"
                name="name"
                value={modalData.name || ""}
                onChange={handleInputChange}
                disabled={mode === "View"}
                aria-label="Section Name"
              />
            </Col>
            <Col md={6}>
              <Input
                type="text"
                placeholder="Class Name"
                name="class_name"
                value={modalData.class_name || ""}
                onChange={handleInputChange}
                disabled={mode === "View"}
                aria-label="Class Name"
              />
            </Col>
          </Row>
          <Row className="mt-3">
            <Col md={6}>
              <Input
                type="textarea"
                placeholder="Capacity"
                name="capacity"
                value={modalData.capacity || ""}
                onChange={handleInputChange}
                disabled={mode === "View"}
                aria-label="Capacity"
              />
            </Col>
            <Col md={6}>
              <Input
                type="text"
                placeholder="Campus Name"
                name="campus_name"
                list="campusOptions" // Link to the datalist ID
                value={modalData.campus_name || ""}
                onChange={handleInputChange}
                disabled={mode === "View"}
                aria-label="Campus Name"
              />
              <datalist id="campusOptions">
                {(modalData.campuses || []).map((campus) => (
                  <option key={campus.id} value={campus.name}>
                    {campus.name}
                  </option>
                ))}
              </datalist>
            </Col>
          </Row>
          <Row className="mt-3">
            <Col md={6}>
              <Input
                type="text"
                placeholder="Teacher In Charge Name"
                name="teacher_in_charge_name"
                value={modalData.teacher_in_charge_name || ""}
                onChange={handleInputChange}
                disabled={mode === "View"}
                aria-label="Teacher In Charge Name"
              />
            </Col>
            <Col md={6}>
              <Input
                type="text"
                placeholder="Teacher In Charge ID"
                name="teacher_in_charge_id"
                value={modalData.teacher_in_charge_id || ""}
                onChange={handleInputChange}
                disabled={mode === "View"}
                aria-label="Teacher In Charge ID"
              />
            </Col>
          </Row>
        </ModalBody>
        <ModalFooter>
          <Button color="link" onClick={toggle}>Cancel</Button>
          {mode !== "View" && (
            <Button color="primary" onClick={handleSubmit}>
              {mode === "Edit" ? "Update" : "Save"}
            </Button>
          )}
        </ModalFooter>
      </Modal>
    </span>
  );
}

export default SectionModal;
