import React, { Fragment } from "react";
import Slider from "react-slick";
import bg3 from "../../../assets/utils/images/originals/citynights.jpg";
import { Col, Row, Button, Form, FormGroup, Label, Input } from "reactstrap";
import { useHistory } from "react-router-dom/cjs/react-router-dom.min";
import { useState } from "react";
import axios from "axios";

function Register() {
  const history = useHistory();

  function handleClick(e) {
    e.preventDefault();
    history.push('Login')
  }
  const [formData, setFormData] = useState({
    name: "",
    email: "",
    password: "",
    // passwordrep: "",
    school: "",
    campus: "",
    mobile: "",
    user_img: ""
  });
  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormData({ ...formData, [name]: value });
  };

  const handleFileChange = (e) => {
    const file = e.target.files[0];
    if (file) {
      setFormData({ ...formData, user_img: file }); // Update state with the file object
    }
  };
  
  const handleSubmit = async (e) => {
    e.preventDefault();
    const data = new FormData();
  
    // Append all form data including the file
    for (const key in formData) {
      data.append(key, formData[key]);
    }
  
    try {
      const response = await axios.post('http://localhost:8000/api/adduser', data, {
        headers: {
          'Content-Type': 'multipart/form-data', // Important for file uploads
        },
      });
      history.push('Login');
      console.log(response.data);
    } catch (error) {
      console.error('Error:', error.response ? error.response.data : error.message);
    }
  };
  
  
  let settings = {
    dots: true,
    infinite: true,
    speed: 500,
    arrows: true,
    slidesToShow: 1,
    slidesToScroll: 1,
    fade: true,
    initialSlide: 0,
    autoplay: true,
    adaptiveHeight: true,
  };

  return (
    <Fragment>
      <div className="h-100">
        <Row className="h-100 g-0">
          <Col
            lg="7"
            md="12"
            className="h-100 d-md-flex d-sm-block bg-white justify-content-center align-items-center"
          >
            <Col lg="9" md="10" sm="12" className="mx-auto app-login-box">
              <div className="app-logo" />
              <h4>
                <div>Welcome,</div>
                <span>
                  It only takes a{" "}
                  <span className="text-success">few seconds</span> to create
                  your account
                </span>
              </h4>
              <div>
              <Form onSubmit={handleSubmit}>
                <Row>
                  <Col md={6}>
                    <FormGroup>
                      <Label for="exampleName">Name</Label>
                      <Input
                        type="text"
                        name="name"
                        id="exampleName"
                        placeholder="Name here..."
                        value={formData.name}
                        onChange={handleChange}
                      />
                    </FormGroup>
                  </Col>
                  <Col md={6}>
                    <FormGroup>
                      <Label for="exampleEmail">
                        <span className="text-danger">*</span> Email
                      </Label>
                      <Input
                        type="email"
                        name="email"
                        id="exampleEmail"
                        placeholder="Email here..."
                        value={formData.email}
                        onChange={handleChange}
                      />
                    </FormGroup>
                  </Col>
                  <Col md={6}>
                    <FormGroup>
                      <Label for="examplePassword">
                        <span className="text-danger">*</span> Password
                      </Label>
                      <Input
                        type="password"
                        name="password"
                        id="examplePassword"
                        placeholder="Password here..."
                        value={formData.password}
                        onChange={handleChange}
                      />
                    </FormGroup>
                  </Col>
                  <Col md={6}>
                    <FormGroup>
                      <Label for="examplePasswordRep">
                        <span className="text-danger">*</span> Repeat Password
                      </Label>
                      <Input
                        type="password"
                        name="password_confirmation"  // Changed here
                        id="examplePasswordRep"
                        placeholder="Repeat Password here..."
                        value={formData.password_confirmation}  // Also updated this to match
                        onChange={handleChange}
                      />
                    </FormGroup>
                  </Col>


                  {/* School Field */}
                  <Col md={6}>
                    <FormGroup>
                      <Label for="exampleSchool">School</Label>
                      <Input
                        type="text"
                        name="school"
                        id="exampleSchool"
                        placeholder="Enter school..."
                        value={formData.school}
                        onChange={handleChange}
                      />
                    </FormGroup>
                  </Col>

                  {/* Campus Field */}
                  <Col md={6}>
                    <FormGroup>
                      <Label for="exampleCampus">Campus</Label>
                      <Input
                        type="text"
                        name="campus"
                        id="exampleCampus"
                        placeholder="Enter campus..."
                        value={formData.campus}
                        onChange={handleChange}
                      />
                    </FormGroup>
                  </Col>

                  {/* Mobile Field */}
                  <Col md={6}>
                    <FormGroup>
                      <Label for="exampleMobile">Mobile</Label>
                      <Input
                        type="text"
                        name="mobile"
                        id="exampleMobile"
                        placeholder="Enter mobile number..."
                        value={formData.mobile}
                        onChange={handleChange}
                      />
                    </FormGroup>
                  </Col>

                  {/* User Image Field */}
                  <Col md={6}>
                    <FormGroup>
                      <Label for="exampleUserImg">Upload Profile Picture</Label>
                      <Input
                        type="file"
                        name="user_img"
                        id="exampleUserImg"
                        accept="image/*" // Accepts only image files
                        onChange={handleFileChange} // Ensure this function is set to handle file change
                      />
                    </FormGroup>
                    {formData.user_img && (
                      <div className="image-preview mt-2">
                        <img
                          src={URL.createObjectURL(formData.user_img)}
                          alt="Profile Preview"
                          style={{ width: '100px', height: '100px', objectFit: 'cover' }} // Adjust dimensions as needed
                        />
                      </div>
                    )}
                  </Col>

                </Row>

                <FormGroup className="mt-3" check>
                  <Input type="checkbox" name="check" id="exampleCheck" />
                  <Label for="exampleCheck" check>
                    Accept our{" "}
                    <a href="https://colorlib.com/" onClick={(e) => e.preventDefault()}>
                      Terms and Conditions
                    </a>
                    .
                  </Label>
                </FormGroup>

                <div className="mt-4 d-flex align-items-center">
                  <h5 className="mb-0">
                    Already have an account?{" "}
                    <a
                      href="https://colorlib.com/"
                      onClick={(e) => e.preventDefault()}
                      className="text-primary"
                    >
                      Sign in
                    </a>
                  </h5>
                  <div className="ms-auto">
                    <Button
                      color="primary"
                      className="btn-wide btn-pill btn-shadow btn-hover-shine"
                      size="lg"
                      type="submit"
                    >
                      Create Account
                    </Button>
                  </div>
                </div>
              </Form>
              </div>
            </Col>
          </Col>
          <Col lg="5" className="d-lg-flex d-xs-none">
            <div className="slider-light">
              <Slider {...settings}>
                <div className="h-100 d-flex justify-content-center align-items-center bg-premium-dark">
                  <div
                    className="slide-img-bg"
                    style={{
                      backgroundImage: "url(" + bg3 + ")",
                    }}
                  />
                  <div className="slider-content">
                    <h3>Scalable, Modular, Consistent</h3>
                    <p>
                      Easily exclude the components you don't require.
                      Lightweight, consistent Bootstrap-based styles across all
                      elements and components.
                    </p>
                  </div>
                </div>
              </Slider>
            </div>
          </Col>
        </Row>
      </div>
    </Fragment>
  );
}

export default Register;
