import React, { Fragment, useState, useEffect } from "react";
import { CSSTransition, TransitionGroup } from 'react-transition-group';
import { Col, Row, Card, CardBody, CardTitle, Button, Form, FormGroup, Label, Input, Container } from "reactstrap";
import axios from "axios";
import { useLocation, useParams, useHistory } from 'react-router-dom';
import Swal from "sweetalert2";

function EditDIR() {
  const location = useLocation();
  const history = useHistory();
  // const id = useParams(); // Get the ID from the URL
  const [formData, setFormData] = useState({
    data: {
      lead_id: '',
      observation_id: '',
      title: '',
      dir_number: '',
      camera_id: '',
      finding_status: '', // Default value for finding status
      finding_remarks: '',
      created_by: 1, // Default value
      department_id: 1, // Default value
      local_cameras_status: '',
      total_cameras: '',
      dir_status: 0, // Default value
      dir_date: '',
      is_deleted: 0,
    }
  });

  const fullURL = window.location.hash; // Get the part after the #
const parts = fullURL.split("/"); // Split the URL by "/"
const id = parts[parts.length - 1]; // Get the last part, which is the ID
console.log(id);

useEffect(() => {
  const fetchData = async () => {
    try {
      const response = await axios.get(`http://127.0.0.1:8000/api/edit_dir/${id}`);
      if (response.status === 200) {
        const record = response.data;
        history.push({
          pathname: `/elements/edit-dir/${id}`,
          state: { record },
        });
        setFormData(record); // Set the fetched record as form data
      } else {
        Swal.fire('Error!', 'Failed to fetch the record.', 'error');
      }
    } catch (error) {
      Swal.fire('Error!', 'An error occurred. Please try again.', 'error');
    }
  };

  fetchData();
}, [id, history]);

  useEffect(() => {
    if (location.state && location.state.record) {
      setFormData(location.state.record);
    }
  }, [location.state]);
console.log('>>>>>>>>>>>>>>>>>>>>>',formData);

const handleChange = (e) => {
  const { name, value } = e.target;

  setFormData((prevState) => ({
    ...prevState,
    data: {
      ...prevState.data,
      [name]: value,
    },
  }));
};

  const handleSubmit = async (e) => {
    // e.preventDefault();    
    try {
      const response = await axios.put(`http://127.0.0.1:8000/api/update_dir/${id}`, formData.data);
      // console.log(response.data);

      // Redirect to the specified URL after a successful form submission
      history.push('/elements/Dir'); // Use history.push to navigate to the "home" path
    } catch (error) {
      console.error("There was an error submitting the form!", error);
      // Display an error message to the user here
    }
  
    // console.log(formData); // Log form data for debugging
  };

  return (
    <Fragment>
      <TransitionGroup>
        <CSSTransition component="div" classNames="TabsAnimation" appear={true} timeout={0} enter={false} exit={false}>
          <Container fluid>
            <Card className="main-card mb-3">
              <CardBody>
                <CardTitle className="text-center">Edit DIR {formData.data ? formData.data.title : formData.title}</CardTitle>
                <Form onSubmit={handleSubmit}>
                  <Row>
                    <Col md={4}>
                      <FormGroup>
                        <Label for="lead_id">Lead ID</Label>
                        <Input type="text" name="lead_id" id="lead_id" value={formData.data.lead_id} onChange={handleChange} placeholder="Lead ID" />
                      </FormGroup>
                    </Col>
                    <Col md={4}>
                      <FormGroup>
                        <Label for="observation_id">Observation ID</Label>
                        <Input type="text" name="observation_id" id="observation_id" value={formData.data.observation_id} onChange={handleChange} placeholder="Observation ID" />
                      </FormGroup>
                    </Col>
                    <Col md={4}>
                      <FormGroup>
                        <Label for="title">Title</Label>
                        <Input type="text" name="title" id="title" value={formData.data.title} onChange={handleChange} placeholder="Title" required />
                      </FormGroup>
                    </Col>
                  </Row>
                  <Row>
                    <Col md={4}>
                      <FormGroup>
                        <Label for="dir_number">DIR Number</Label>
                        <Input type="text" name="dir_number" id="dir_number" value={formData.data.dir_number} onChange={handleChange} placeholder="DIR Number" required />
                      </FormGroup>
                    </Col>
                    <Col md={4}>
                      <FormGroup>
                        <Label for="camera_id">Camera ID</Label>
                        <Input type="text" name="camera_id" id="camera_id" value={formData.data.camera_id} onChange={handleChange} placeholder="Camera ID" required />
                      </FormGroup>
                    </Col>
                    <Col md={4}>
                      <FormGroup>
                        <Label>Finding Status</Label>
                        <div>
                          <Label check>
                            <Input type="radio" name="finding_status" value="1" checked={formData.data.finding_status === '1'} onChange={handleChange} required />
                            Found
                          </Label>
                          <Label check className="ml-3">
                            <Input type="radio" name="finding_status" value="0" checked={formData.data.finding_status === '0'} onChange={handleChange} required />
                            Not Found
                          </Label>
                        </div>
                      </FormGroup>
                    </Col>
                  </Row>
                  <Row>
                    {/* Hidden fields for created_by and department_id */}
                    <Col md={4} style={{ display: 'none' }}>
                      <FormGroup>
                        <Input type="hidden" name="created_by" value={formData.data.created_by} />
                      </FormGroup>
                    </Col>
                    <Col md={4} style={{ display: 'none' }}>
                      <FormGroup>
                        <Input type="hidden" name="department_id" value={formData.data.department_id} />
                      </FormGroup>
                    </Col>
                  </Row>
                  <Row>
                    <Col md={4}>
                      <FormGroup>
                        <Label>Local Cameras Status</Label>
                        <div>
                          <Label check>
                            <Input type="radio" name="local_cameras_status" value="1" checked={formData.data.local_cameras_status === '1'} onChange={handleChange} required />
                            Found
                          </Label>
                          <Label check className="ml-3">
                            <Input type="radio" name="local_cameras_status" value="0" checked={formData.data.local_cameras_status === '0'} onChange={handleChange} required />
                            Not Found
                          </Label>
                        </div>
                      </FormGroup>
                    </Col>
                    <Col md={4}>
                      <FormGroup>
                        <Label for="total_cameras">Total Cameras</Label>
                        <Input type="number" name="total_cameras" id="total_cameras" value={formData.data.total_cameras} onChange={handleChange} placeholder="Total Cameras" required />
                      </FormGroup>
                    </Col>
                    <Col md={4}>
                      <FormGroup>
                        <Label for="dir_date">DIR Date</Label>
                        <Input type="date" name="dir_date" id="dir_date" value={formData.data.dir_date} onChange={handleChange} required />
                      </FormGroup>
                    </Col>
                  </Row>
                  <Row>
                    <Col md={4} style={{ display: 'none' }}>
                      <FormGroup>
                        <Label for="dir_status">DIR Status</Label>
                        <Input type="hidden" name="dir_status" value={formData.data.dir_status} />
                      </FormGroup>
                    </Col>
                    <Col md={12}>
                      <FormGroup>
                        <Label for="finding_remarks">Finding Remarks</Label>
                        <Input type="textarea" name="finding_remarks" id="finding_remarks" value={formData.data.finding_remarks} onChange={handleChange} placeholder="Finding Remarks" required />
                      </FormGroup>
                    </Col>
                  </Row>
                  <Button color="primary" className="mt-2" onClick={() => handleSubmit(formData.data.id)} type="submit">
                    Update DIR
                  </Button>
                </Form>
              </CardBody>
            </Card>
          </Container>
        </CSSTransition>
      </TransitionGroup>
    </Fragment>
  );
}

export default EditDIR;
