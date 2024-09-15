import React, { Fragment, useState } from "react";
import { CSSTransition, TransitionGroup } from 'react-transition-group';
import {  Col,  Row,  Card,  CardBody,  CardTitle,  Button,  Form,  FormGroup,  Label,  Input,  Container,} from "reactstrap";
import axios from "axios";

function AddClass() {
  const today = new Date().toISOString().split('T')[0];

  const [formData, setFormData] = useState({
    lead_id: '',
    observation_id: '',
    title: '',
    teacher_in_charge_name: '',
    camera_id: '',
    status: '', // Default value for finding status
    finding_remarks: '',
    created_by: 1, // Default value
    department_id: 1, // Default value
    local_cameras_status: '',
    total_cameras: '',
    dir_status: 0, // Default value
    dir_date: today,

    is_deleted: 0,
  });

  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormData({ ...formData, [name]: value });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();    
    try {
      const response = await axios.post('http://127.0.0.1:8000/api/classes/store', formData);
      console.log(response.data);
      

      setFormData({
        lead_id: '',
        observation_id: '',
        title: '',
        teacher_in_charge_name: '',
        camera_id: '',
        status: '', // Reset to default value
        finding_remarks: '',
        created_by: 1, // Reset to default value
        department_id: 1, // Reset to default value
        local_cameras_status: '',
        total_cameras: '',
        dir_status: 0, // Reset to default value
        dir_date: '',
        is_deleted: 0,
      });
  
      // Redirect to the specified URL after a successful form submission
      window.location.href = 'http://localhost:3000/architectui-react-pro#/elements/classes/classes';
    } catch (error) {
      console.error("There was an error submitting the form!", error);
      // Display an error message to the user here
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
                <CardTitle className="text-center">Add Classs</CardTitle>
                <Form onSubmit={handleSubmit}>
                  <Row>
                   
                    <Col md={4}>
                      <FormGroup>
                        <Label for="name">Class Name</Label>

                        <Input type="text" name="name" id="name" value={formData.name} onChange={handleChange} placeholder="Class name" required/>

                      </FormGroup>
                    </Col>
                    <Col md={4}>
                      <FormGroup>
                        <Label for="teacher_in_charge_name">Teacher incharge name</Label>
                        <Input type="text" name="teacher_in_charge_name" id="teacher_in_charge_name" value={formData.teacher_in_charge_name} onChange={handleChange} placeholder="Teacher incharge name" required/>

                      </FormGroup>
                    </Col>
                    <Col md={4}>
                      <FormGroup>
                        <Label>Status</Label>
                        <div>
                          <Label check>
                            <Input type="radio" name="status" value="1" checked={formData.status === '1'} onChange={handleChange} required/>
                           Enable
                          </Label>
                          <Label check className="ml-3">
                            <Input type="radio" name="status" value="0" checked={formData.status === '0'} onChange={handleChange} required/>

                           Disable
                          </Label>
                        </div>
                      </FormGroup>
                    </Col>
                    
                  </Row>
                
                 
                  <Button color="primary" className="mt-2" type="submit">
                    Add Class
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

export default AddClass;
