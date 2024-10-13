import React, { useState, useCallback } from "react";
import { Button, Modal, ModalHeader, ModalBody, ModalFooter, Input, Row, Col } from "reactstrap";
import axios from "axios";
import { toast } from "react-toastify";

function SectionModal({ modalOpen, setModalOpen, modalData, setModalData, mode, fetchData, handleEdit, currentPage }) {
  const modalPage = currentPage + 1;

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
                placeholder="Class ID"
                name="class_id"
                value={modalData.class_id || ""}
                onChange={handleInputChange}
                disabled={mode === "View"}
                aria-label="Class ID"
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
                placeholder="Campus ID"
                name="campus_id"
                value={modalData.campus_id || ""}
                onChange={handleInputChange}
                disabled={mode === "View"}
                aria-label="Campus ID"
              />
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
