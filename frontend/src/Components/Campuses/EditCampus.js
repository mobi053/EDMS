import React, { Fragment, useState, useEffect } from "react";
import { CSSTransition, TransitionGroup } from 'react-transition-group';
import { Col, Row, Card, CardBody, CardTitle, Button, Form, FormGroup, Label, Input, Container } from "reactstrap";
import axios from "axios";
import { useLocation, useParams, useHistory } from 'react-router-dom';
import Swal from "sweetalert2";

function EditCampus() {
  const location = useLocation();
  const history = useHistory();
  // const id = useParams(); // Get the ID from the URL
  const [formData, setFormData] = useState({
    data: {
      id: '',
      name: '',
      teacher_in_charge_name: '',
      status: '', // Default value for finding status
      
    }
  });

  const fullURL = window.location.hash; // Get the part after the #
  const parts = fullURL.split("/"); // Split the URL by "/"
  const id = parts[parts.length - 1]; // Get the last part, which is the ID
  console.log(id);

useEffect(() => {
  const fetchData = async () => {
    try {
      const response = await axios.get(`http://127.0.0.1:8000/api/classes/edit_class/${id}`);
      if (response.status === 200) {
        const record = response.data;
        history.push({
          pathname: `/elements/classes/edit-class/${id}`,
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
    e.preventDefault();    
    try {
      const response = await axios.put(`http://127.0.0.1:8000/api/classes/update/${id}`, formData.data);
      // console.log(response.data);

      // Redirect to the specified URL after a successful form submission
      history.push('/elements/classes/classes'); // Use history.push to navigate to the "home" path
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
                        <Label for="name">Name</Label>
                        <Input type="text" name="name" id="name" value={formData.data.name} onChange={handleChange} placeholder="Class Name" required />
                      </FormGroup>
                    </Col>
                    

                    <Col md={4}>
                      <FormGroup>
                        <Label for="teacher_in_charge_name">Teacher incharge name</Label>
                        <Input type="text" name="teacher_in_charge_name" id="teacher_in_charge_name" value={formData.data.teacher_in_charge_name} onChange={handleChange} placeholder="Teacher incharge name" required />
                      </FormGroup>
                    </Col>
                    <Col md={4}>
                      <FormGroup>
                        <Label>Status</Label>
                        <div>
                          <Label check>
                            <Input type="radio" name="status" value="1" checked={parseInt(formData.data.status) === 1} onChange={handleChange} required />
                            Enable
                          </Label>
                          <Label check className="ml-3">
                            <Input type="radio" name="status" value="0" checked={parseInt(formData.data.status) === 0} onChange={handleChange} required />
                            Disable
                          </Label>
                        </div>
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

export default EditCampus;
