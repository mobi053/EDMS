import React, { useState } from "react";
import { Button, Modal, ModalHeader, ModalBody, ModalFooter, Input, Form, FormGroup } from "reactstrap";
import axios from "axios"; // Make sure to install axios

function ModalDIR(props) {
  const [modal, setModal] = useState(false);
  const [formData, setFormData] = useState({
    lead_id: "",
    observation_id: "",
    title: "",
    dir_number: "",
    camera_id: "",
    finding_status: false,
    finding_remarks: "",
    created_by: "",
    department_id: "",
    local_cameras_status: false,
    total_cameras: "",
    dir_status: false,
    dir_date: "",
    is_deleted: false,
  });

  const toggle = () => {
    setModal(!modal);
  };

  const handleChange = (e) => {
    const { name, value, type, checked } = e.target;
    setFormData({
      ...formData,
      [name]: type === "checkbox" ? checked : value,
    });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    try {
      const response = await axios.post('http://127.0.0.1:8000/api/add_dir', formData);
      console.log(response.data); // Handle success response
      // Optionally reset the form
      setFormData({
        lead_id: "",
        observation_id: "",
        title: "",
        dir_number: "",
        camera_id: "",
        finding_status: false,
        finding_remarks: "",
        created_by: "",
        department_id: "",
        local_cameras_status: false,
        total_cameras: "",
        dir_status: false,
        dir_date: "",
        is_deleted: false,
      });
      toggle(); // Close the modal after submission
    } catch (error) {
      console.error("There was an error inserting the DIR!", error.response.data);
      // Handle error response (e.g., show a notification)
    }
  };

  const closeBtn = (
    <button className="btn-close" onClick={toggle}>
      &times;
    </button>
  );

  return (
    <span className="d-inline-block mb-2 me-2">
      <Button color="primary" onClick={toggle}>
        Custom Close Button
      </Button>
      <Modal isOpen={modal} toggle={toggle} className={props.className}>
        <ModalHeader toggle={toggle} close={closeBtn}>
          Insert DIR Record
        </ModalHeader>
        <ModalBody>
          <Form onSubmit={handleSubmit}>
            <FormGroup>
              <label htmlFor="lead_id">Lead ID</label>
              <Input type="text" name="lead_id" id="lead_id" value={formData.lead_id} onChange={handleChange} required />
            </FormGroup>
            <FormGroup>
              <label htmlFor="observation_id">Observation ID</label>
              <Input type="text" name="observation_id" id="observation_id" value={formData.observation_id} onChange={handleChange} />
            </FormGroup>
            <FormGroup>
              <label htmlFor="title">Title</label>
              <Input type="text" name="title" id="title" value={formData.title} onChange={handleChange} required />
            </FormGroup>
            <FormGroup>
              <label htmlFor="dir_number">DIR Number</label>
              <Input type="text" name="dir_number" id="dir_number" value={formData.dir_number} onChange={handleChange} />
            </FormGroup>
            <FormGroup>
              <label htmlFor="camera_id">Camera ID</label>
              <Input type="text" name="camera_id" id="camera_id" value={formData.camera_id} onChange={handleChange} />
            </FormGroup>
            <FormGroup>
              <label htmlFor="finding_status">Finding Status</label>
              <Input type="checkbox" name="finding_status" id="finding_status" checked={formData.finding_status} onChange={handleChange} />
            </FormGroup>
            <FormGroup>
              <label htmlFor="finding_remarks">Finding Remarks</label>
              <Input type="textarea" name="finding_remarks" id="finding_remarks" value={formData.finding_remarks} onChange={handleChange} />
            </FormGroup>
            <FormGroup>
              <label htmlFor="created_by">Created By</label>
              <Input type="text" name="created_by" id="created_by" value={formData.created_by} onChange={handleChange} required />
            </FormGroup>
            <FormGroup>
              <label htmlFor="department_id">Department ID</label>
              <Input type="text" name="department_id" id="department_id" value={formData.department_id} onChange={handleChange} required />
            </FormGroup>
            <FormGroup>
              <label htmlFor="local_cameras_status">Local Cameras Status</label>
              <Input type="checkbox" name="local_cameras_status" id="local_cameras_status" checked={formData.local_cameras_status} onChange={handleChange} />
            </FormGroup>
            <FormGroup>
              <label htmlFor="total_cameras">Total Cameras</label>
              <Input type="number" name="total_cameras" id="total_cameras" value={formData.total_cameras} onChange={handleChange} required />
            </FormGroup>
            <FormGroup>
              <label htmlFor="dir_status">DIR Status</label>
              <Input type="checkbox" name="dir_status" id="dir_status" checked={formData.dir_status} onChange={handleChange} />
            </FormGroup>
            <FormGroup>
              <label htmlFor="dir_date">DIR Date</label>
              <Input type="date" name="dir_date" id="dir_date" value={formData.dir_date} onChange={handleChange} />
            </FormGroup>
            <FormGroup>
              <label htmlFor="is_deleted">Is Deleted</label>
              <Input type="checkbox" name="is_deleted" id="is_deleted" checked={formData.is_deleted} onChange={handleChange} />
            </FormGroup>
            <Button type="submit" color="primary">Submit</Button>
          </Form>
        </ModalBody>
        <ModalFooter>
          <Button color="link" onClick={toggle}>
            Cancel
          </Button>
        </ModalFooter>
      </Modal>
    </span>
  );
}

export default ModalDIR;
