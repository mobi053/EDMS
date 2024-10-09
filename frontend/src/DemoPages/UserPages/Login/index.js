import React, { Fragment, useState } from "react";
import { useHistory } from 'react-router-dom';

import Slider from "react-slick";
import bg1 from "../../../assets/utils/images/originals/city.jpg";
import bg2 from "../../../assets/utils/images/originals/citydark.jpg";
import bg3 from "../../../assets/utils/images/originals/citynights.jpg";

import { Col, Row, Button, Form, FormGroup, Label, Input } from "reactstrap";

function Login() {
  const settings = {
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

  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [error, setError] = useState('');
  const history = useHistory();

  // Handle form submission
  const handleSubmit = async (e) => {
    e.preventDefault();
    setError('');

    if (!email || !password) {
        setError('Please fill in both fields');
        return;
    }

    try {
        const response = await fetch('http://localhost:8000/api/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ email, password }),  // Send email and password as JSON
        });

        const data = await response.json();

        if (response.ok) {
            const token = data.token;
            const user = data.user;  // Assuming the API returns user data along with the token
            localStorage.setItem('userName', user.name);
            localStorage.setItem('userId', user.id);
            localStorage.setItem('authToken', token);

            // Redirect to the dashboard or desired page after successful login
            history.push('/elements/Dir');
        } else {
            setError(data.message || 'Login failed');
        }
    } catch (err) {
        setError('An error occurred. Please try again.');
    }
  };

  return (
    <Fragment>
      <div className="h-100">
        <Row className="h-100 g-0">
          <Col lg="4" className="d-none d-lg-block">
            <div className="slider-light">
              <Slider {...settings}>
                <div className="h-100 d-flex justify-content-center align-items-center bg-plum-plate">
                  <div className="slide-img-bg"
                    style={{ backgroundImage: `url(${bg1})` }}
                  />
                  <div className="slider-content">
                    <h3>Perfect Balance</h3>
                    <p>
                      ArchitectUI is like a dream. Some think it's too good to be true!
                    </p>
                  </div>
                </div>
                <div className="h-100 d-flex justify-content-center align-items-center bg-premium-dark">
                  <div className="slide-img-bg"
                    style={{ backgroundImage: `url(${bg3})` }}
                  />
                  <div className="slider-content">
                    <h3>Scalable, Modular, Consistent</h3>
                    <p>
                      Lightweight, consistent Bootstrap based styles across all elements.
                    </p>
                  </div>
                </div>
                <div className="h-100 d-flex justify-content-center align-items-center bg-sunny-morning">
                  <div className="slide-img-bg opacity-6"
                    style={{ backgroundImage: `url(${bg2})` }}
                  />
                  <div className="slider-content">
                    <h3>Complex, but lightweight</h3>
                    <p>
                      We've included a lot of components that cover almost all use cases.
                    </p>
                  </div>
                </div>
              </Slider>
            </div>
          </Col>
          <Col lg="8" md="12" className="h-100 d-flex bg-white justify-content-center align-items-center">
            <Col lg="9" md="10" sm="12" className="mx-auto app-login-box">
              <div className="app-logo" />
              <h4 className="mb-0">
                <div>Welcome back,</div>
                <span>Please sign in to your account.</span>
              </h4>
              <h6 className="mt-3">
                No account?{" "}
                <a href="https://colorlib.com/" onClick={(e) => e.preventDefault()} className="text-primary">
                  Sign up now
                </a>
              </h6>
              <Row className="divider" />
              <div>
                <Form onSubmit={handleSubmit}>
                  <Row>
                    <Col md={6}>
                      <FormGroup>
                        <Label for="exampleEmail">Email</Label>
                        <Input
                          type="email"
                          name="email"
                          id="exampleEmail"
                          placeholder="Email here..."
                          value={email}
                          onChange={(e) => setEmail(e.target.value)} // Update email state
                        />
                      </FormGroup>
                    </Col>
                    <Col md={6}>
                      <FormGroup>
                        <Label for="examplePassword">Password</Label>
                        <Input
                          type="password"
                          name="password"
                          id="examplePassword"
                          placeholder="Password here..."
                          value={password}
                          onChange={(e) => setPassword(e.target.value)} // Update password state
                        />
                      </FormGroup>
                    </Col>
                  </Row>
                  <FormGroup check>
                    <Input type="checkbox" name="check" id="exampleCheck" />
                    <Label for="exampleCheck" check>
                      Keep me logged in
                    </Label>
                  </FormGroup>
                  {error && <p style={{ color: 'red' }}>{error}</p>} {/* Display error if exists */}
                  <Row className="divider" />
                  <div className="d-flex align-items-center">
                    <div className="ms-auto">
                      <a href="https://colorlib.com/" onClick={(e) => e.preventDefault()} className="btn-lg btn btn-link">
                        Recover Password
                      </a>{" "}
                      <Button color="primary" size="lg" type="submit">
                        Login to Dashboard
                      </Button>
                    </div>
                  </div>
                </Form>
              </div>
            </Col>
          </Col>
        </Row>
      </div>
    </Fragment>
  );
}

export default Login;
