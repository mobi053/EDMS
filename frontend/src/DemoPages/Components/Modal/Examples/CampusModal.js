import React, { useState, useCallback } from "react";
import { Button, Modal, ModalHeader, ModalBody, ModalFooter, Input, Row, Col } from "reactstrap";
import axios from "axios";
import { toast } from "react-toastify";
import { FormControl } from "@mui/material";

function CampusModal({ modalOpen, setModalOpen, modalData, setModalData, mode, fetchData, handleEdit, currentPage }) {
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
      return toast('Please enter Campus Name');
    }
    if (!modalData.principal) {
      return toast('Please enter Principal Name');
    }
    try {
      if (mode === "Add") {
        await axios.post('http://127.0.0.1:8000/api/campuses/store', modalData);
        fetchData("", 10, modalPage);
        toggle();
      } else if (mode === "Edit") {
        const id = modalData.id;
        await axios.put(`http://127.0.0.1:8000/api/campuses/update/${id}`, modalData);
        fetchData("", 10, modalPage);
        toggle();
      }
    } catch (error) {
      alert("Failed to save campus. Please try again.");
    }
  };

  return (
    <span className="d-inline-block mb-2 me-2">
      <Modal isOpen={modalOpen} toggle={toggle} size="lg" className={'abc'}>
        <ModalHeader toggle={toggle}>
          {mode === "View" ? "View Campus" : mode === "Edit" ? "Edit Campus" : "Add Campus"}
        </ModalHeader>
        <ModalBody>
          <Row>
            {/* First column */}
            <Col md={6}>
              <Input type="text" placeholder="Campus Name" name="name" value={modalData.name || ""} onChange={handleInputChange} disabled={mode === "View"} required={mode === "Add"} />
            </Col>
            {/* Second column */}
            <Col md={6}>
              <Input type="text" placeholder="Campus Code" name="campus_code" value={modalData.campus_code || ""} onChange={handleInputChange} disabled={mode === "View"} required={mode === "Add"} />
            </Col>
          </Row>

          <Row className="mt-3">
            {/* First column */}
            <Col md={6}>
              <Input type="textarea" placeholder="Principal Name" name="principal" value={modalData.principal || ""} onChange={handleInputChange} disabled={mode === "View"} required={mode === "Add"} />
            </Col>
            {/* Second column */}
            <Col md={6}>
              <Input type="text" placeholder="Location" name="location" value={modalData.location || ""} onChange={handleInputChange} disabled={mode === "View"} />
            </Col>
          </Row>

          <Row className="mt-3">
            {/* First column */}
            <Col md={6}>
              <Input type="text" placeholder="District" name="district" value={modalData.district || ""} onChange={handleInputChange} disabled={mode === "View"} />
            </Col>
            {/* Second column */}
            <Col md={6}>
              <Input type="text" placeholder="Country" name="country" value={modalData.country || ""} onChange={handleInputChange} disabled={mode === "View"} />
            </Col>
          </Row>

          <Row className="mt-3">
            {/* First column */}
            <Col md={6}>
              <Input type="text" placeholder="Phone Number" name="phone_number" value={modalData.phone_number || ""} onChange={handleInputChange} disabled={mode === "View"} />
            </Col>
            {/* Second column */}
            <Col md={6}>
              <Input type="email" placeholder="Email" name="email" value={modalData.email || ""} onChange={handleInputChange} disabled={mode === "View"} />
            </Col>
          </Row>

          <Row className="mt-3">
            {/* First column */}
            <Col md={6}>
              <Input type="text" placeholder="Campus Type" name="campus_type" value={modalData.campus_type || ""} onChange={handleInputChange} disabled={mode === "View"} />
            </Col>
            {/* Second column */}
            <Col md={6}>
              <Input type="select" name="is_active" value={modalData.is_active || ""} onChange={handleInputChange} disabled={mode === "View"}>
                <option value="">Select Status</option>
                <option value="1">Active</option>
                <option value="0">Inactive</option>
              </Input>
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

export default CampusModal;
