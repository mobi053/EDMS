import React, { useState } from "react";
import { Button, Modal, ModalHeader, ModalBody, ModalFooter } from "reactstrap";
import axios from "axios";

function ModalExample(props) {
  const [modal, setModal] = useState(false);
  const [formData, setFormData] = useState({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
  });
  const [error, setError] = useState("");

  function toggle() {
    setModal(!modal);
  }

  function handleChange(e) {
    const { name, value } = e.target;
    setFormData((prevState) => ({
      ...prevState,
      [name]: value,
    }));
  }

  console.log(formData)

  async function handleSubmit(e) {
    e.preventDefault();
    setError("");

    try {
      const response = await axios.post(
        "http://127.0.0.1:8000/api/adduser",
        formData,
        {
          headers: {
            "Content-Type": "application/json",
          },
        }
      );
      console.log(response.status);
      
      if (response.status === 201) {
        // Handle success (e.g., show a success message or update state)
        console.log("User added successfully:", response.data);
        toggle(); // Close the modal
        window.location.reload();
      } else {
        // Handle error
        setError(response.data.message || "An error occurredddd.");
      }
    } catch (error) {
      if (error.response) {
        setError(error.response.data.message || "An error occurred.");
      } else {
        setError("An error occurred. Please try again.");
      }
    }
  }

  return (
    <span className="d-inline-block mb-2 me-2">
      <Button color="primary" onClick={toggle}>
        Add User
      </Button>
      <Modal isOpen={modal} toggle={toggle} className={props.className}>
        <ModalHeader toggle={toggle}>Create User</ModalHeader>
        <ModalBody>
          <form onSubmit={handleSubmit}>
            <div>
              <label htmlFor="name">Name:</label>
              <input
                type="text"
                name="name"
                id="name"
                value={formData.name}
                onChange={handleChange}
                required
              />
            </div>
            <div>
              <label htmlFor="email">Email:</label>
              <input
                type="email"
                name="email"
                id="email"
                value={formData.email}
                onChange={handleChange}
                required
              />
            </div>
            <div>
              <label htmlFor="password">Password:</label>
              <input
                type="password"
                name="password"
                id="password"
                value={formData.password}
                onChange={handleChange}
                required
              />
            </div>
            <div>
              <label htmlFor="password_confirmation">Confirm Password:</label>
              <input
                type="password"
                name="password_confirmation"
                id="password_confirmation"
                value={formData.password_confirmation}
                onChange={handleChange}
                required
              />
            </div>
            {error && <p className="text-danger">{error}</p>}
            <Button type="submit" color="primary">
              Create
            </Button>
          </form>
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

export default ModalExample;
