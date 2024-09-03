import React, { Fragment, useState, useEffect } from "react";
import { CSSTransition, TransitionGroup } from 'react-transition-group';
import { Col, Row, Card, CardBody, CardTitle, Button, Form, FormGroup, Label, Input, Container } from "reactstrap";
import axios from "axios";
import { useParams, useHistory } from 'react-router-dom';

function EditDIR() {
  const { id } = useParams(); // Get the ID from the route params
  const history = useHistory();
  
  const [formData, setFormData] = useState({
    lead_id: '',
    observation_id: '',
    title: '',
    dir_number: '',
    camera_id: '',
    finding_status: '',
    finding_remarks: '',
    created_by: 1,
    department_id: 1,
    local_cameras_status: '',
    total_cameras: '',
    dir_status: 0,
    dir_date: '',
    is_deleted: 0,
  });

  useEffect(() => {
    // Fetch the directory details when component mounts
    const fetchData = async () => {
      try {
        const response = await axios.get(`http://127.0.0.1:8000/api/dir/${id}`);
        setFormData(response.data);
      } catch (error) {
        console.error("There was an error fetching the directory details!", error);
      }
    };

    fetchData();
  }, [id]);

  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormData({ ...formData, [name]: value });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    try {
      const response = await axios.put(`http://127.0.0.1:8000/api/update_dir/${id}`, formData);
      console.log(response.data);

      // Redirect to the specified URL after successful update
      history.push('/elements/Dir');
    } catch (error) {
      console.error("There was an error submitting the form!", error);
    }

    console.log(formData); // Log form data for debugging
  };

  return (
    <Fragment>
      <TransitionGroup>
        <CSSTransition component="div" classNames="TabsAnimation" appear={true} timeout={0} enter={false} exit={false}>
          <Container fluid>
            <Card className="main-card mb-3">
              <CardBody>
                <CardTitle className="text-center">Edit DIR</CardTitle>
                <Form onSubmit={handleSubmit}>
                  <Row>
                    <Col md={4}>
                      <FormGroup>
                        <Label for="lead_id">Lead ID</Label>
                        <Input type="text" name="lead_id" id="lead_id" value={formData.lead_id} onChange={handleChange} placeholder="Lead ID" />
                      </FormGroup>
                    </Col>
                    <Col md={4}>
                      <FormGroup>
                        <Label for="observation_id">Observation ID</Label>
                        <Input type="text" name="observation_id" id="observation_id" value={formData.observation_id} onChange={handleChange} placeholder="Observation ID" />
                      </FormGroup>
                    </Col>
                    <Col md={4}>
                      <FormGroup>
                        <Label for="title">Title</Label>
                        <Input type="text" name="title" id="title" value={formData.title} onChange={handleChange} placeholder="Title" required />
                      </FormGroup>
                    </Col>
                  </Row>
                  <Row>
                    <Col md={4}>
                      <FormGroup>
                        <Label for="dir_number">DIR Number</Label>
                        <Input type="text" name="dir_number" id="dir_number" value={formData.dir_number} onChange={handleChange} placeholder="DIR Number" required />
                      </FormGroup>
                    </Col>
                    <Col md={4}>
                      <FormGroup>
                        <Label for="camera_id">Camera ID</Label>
                        <Input type="text" name="camera_id" id="camera_id" value={formData.camera_id} onChange={handleChange} placeholder="Camera ID" required />
                      </FormGroup>
                    </Col>
                    <Col md={4}>
                      <FormGroup>
                        <Label>Finding Status</Label>
                        <div>
                          <Label check>
                            <Input type="radio" name="finding_status" value="1" checked={formData.finding_status === '1'} onChange={handleChange} required />
                            Found
                          </Label>
                          <Label check className="ml-3">
                            <Input type="radio" name="finding_status" value="0" checked={formData.finding_status === '0'} onChange={handleChange} required />
                            Not Found
                          </Label>
                        </div>
                      </FormGroup>
                    </Col>
                  </Row>
                  <Row>
                    <Col md={4} style={{ display: 'none' }}>
                      <FormGroup>
                        <Input type="hidden" name="created_by" value={formData.created_by} />
                      </FormGroup>
                    </Col>
                    <Col md={4} style={{ display: 'none' }}>
                      <FormGroup>
                        <Input type="hidden" name="department_id" value={formData.department_id} />
                      </FormGroup>
                    </Col>
                  </Row>
                  <Row>
                    <Col md={4}>
                      <FormGroup>
                        <Label>Local Cameras Status</Label>
                        <div>
                          <Label check>
                            <Input type="radio" name="local_cameras_status" value="1" checked={formData.local_cameras_status === '1'} onChange={handleChange} required />
                            Found
                          </Label>
                          <Label check className="ml-3">
                            <Input type="radio" name="local_cameras_status" value="0" checked={formData.local_cameras_status === '0'} onChange={handleChange} required />
                            Not Found
                          </Label>
                        </div>
                      </FormGroup>
                    </Col>
                    <Col md={4}>
                      <FormGroup>
                        <Label for="total_cameras">Total Cameras</Label>
                        <Input type="number" name="total_cameras" id="total_cameras" value={formData.total_cameras} onChange={handleChange} placeholder="Total Cameras" required />
                      </FormGroup>
                    </Col>
                    <Col md={4}>
                      <FormGroup>
                        <Label for="dir_date">DIR Date</Label>
                        <Input type="date" name="dir_date" id="dir_date" value={formData.dir_date} onChange={handleChange} required />
                      </FormGroup>
                    </Col>
                  </Row>
                  <Row>
                    <Col md={4} style={{ display: 'none' }}>
                      <FormGroup>
                        <Label for="dir_status">DIR Status</Label>
                        <Input type="hidden" name="dir_status" value={formData.dir_status} />
                      </FormGroup>
                    </Col>
                    <Col md={12}>
                      <FormGroup>
                        <Label for="finding_remarks">Finding Remarks</Label>
                        <Input type="textarea" name="finding_remarks" id="finding_remarks" value={formData.finding_remarks} onChange={handleChange} placeholder="Finding Remarks" required />
                      </FormGroup>
                    </Col>
                  </Row>
                  <Button color="primary" className="mt-2" type="submit">
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
