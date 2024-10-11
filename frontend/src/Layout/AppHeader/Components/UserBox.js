import React, { Fragment, useState } from "react";
import { IoIosCalendar } from "react-icons/io";
import PerfectScrollbar from "react-perfect-scrollbar";
import {  DropdownToggle,  DropdownMenu,  Nav,  Col,  Row,  Button,  NavItem,  NavLink,  UncontrolledTooltip,  UncontrolledButtonDropdown,} from "reactstrap";
import { toast, Bounce } from "react-toastify";
import { faAngleDown } from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import 'react-toastify/dist/ReactToastify.css';
import city3 from "../../../assets/utils/images/dropdown-header/city3.jpg";
import avatar1 from "../../../assets/utils/images/avatars/user1.jpg";
import axios from "axios"; // Make sure axios is imported
import { useParams, useHistory } from 'react-router-dom';


function UserBox() {
  const [active, setActive] = useState(false);
  const userName = localStorage.getItem('userName');
  const userId = localStorage.getItem('userId');
  const history = useHistory();

  function notify2() {
    toast(
      "You don't have any new items in your calendar for today! Go out and play!",
      {
        transition: Bounce,
        closeButton: true,
        autoClose: 5000,
        position: "bottom-center",
        type: "success",
      }
    );
  }
  function handleLogout() {

    const token = localStorage.getItem('authToken'); // Assuming the token is stored in localStorage
    axios.post('http://127.0.0.1:8000/api/apiLogout', {}, {
      headers: {
        Authorization: `Bearer ${token}`, // Include the token in the Authorization header
      }
    })
    .then(response => {
      console.log(response.data.message);
      localStorage.removeItem('userName'); // Clear user data
      localStorage.removeItem('userId');
      localStorage.removeItem('authToken'); // Remove token from localStorage
      // window.location.href = '/login'; // Redirect to login
      history.push('/pages/Login');
    })
    .catch(error => {
      console.error('There was an error logging out!', error);
    });
  }

  return (
    <Fragment>
      <div className="header-btn-lg pe-0">
        <div className="widget-content p-0">
          <div className="widget-content-wrapper">
            <div className="widget-content-left">
              <UncontrolledButtonDropdown>
                <DropdownToggle color="link" className="p-0">
                  <img width={42} className="rounded-circle" src={avatar1} alt=""/>
                  <FontAwesomeIcon
                    className="ms-2 opacity-8"
                    icon={faAngleDown}
                  />
                </DropdownToggle>
                <DropdownMenu end className="rm-pointers dropdown-menu-lg">
                  <div className="dropdown-menu-header">
                    <div className="dropdown-menu-header-inner bg-info">
                      <div className="menu-header-image opacity-2"
                        style={{
                          backgroundImage: "url(" + city3 + ")",
                        }}/>
                      <div className="menu-header-content text-start">
                        <div className="widget-content p-0">
                          <div className="widget-content-wrapper">
                            <div className="widget-content-left me-3">
                              <img width={42} className="rounded-circle" src={avatar1} alt=""/>
                            </div>
                            <div className="widget-content-left">
                              <div className="widget-heading">
                                {userName}-{userId}
                              </div>
                              <div className="widget-subheading opacity-8">
                                Police Communication Officer
                              </div>
                            </div>
                            <div className="widget-content-right me-2">
                              <Button 
                                  className="btn-pill btn-shadow btn-shine" 
                                  color="focus"
                                  onClick={handleLogout} // Attach the logout handler
                                >
                                Logout
                              </Button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  {/* <div className="scroll-area-xs"
                    style={{
                      height: "150px",
                    }}>
                    <PerfectScrollbar>
                      <Nav vertical>
                        <NavItem className="nav-item-header">
                          Activity
                        </NavItem>
                        <NavItem>
                          <NavLink href="#">
                            Chat
                            <div className="ms-auto badge rounded-pill bg-info">
                              8
                            </div>
                          </NavLink>
                        </NavItem>
                        <NavItem>
                          <NavLink href="#">Recover Password</NavLink>
                        </NavItem>
                        <NavItem className="nav-item-header">
                          My Account
                        </NavItem>
                        <NavItem>
                          <NavLink href="#">
                            Settings
                            <div className="ms-auto badge bg-success">
                              New
                            </div>
                          </NavLink>
                        </NavItem>
                        <NavItem>
                          <NavLink href="#">
                            Messages
                            <div className="ms-auto badge bg-warning">
                              512
                            </div>
                          </NavLink>
                        </NavItem>
                        <NavItem>
                          <NavLink href="#">Logs</NavLink>
                        </NavItem>
                      </Nav>
                    </PerfectScrollbar>
                  </div>
                  <Nav vertical>
                    <NavItem className="nav-item-divider mb-0" />
                  </Nav>
                  <div className="grid-menu grid-menu-2col">
                    <Row className="g-0">
                      <Col sm="6">
                        <Button className="btn-icon-vertical btn-transition btn-transition-alt pt-2 pb-2"
                          outline color="warning">
                          <i className="pe-7s-chat icon-gradient bg-amy-crisp btn-icon-wrapper mb-2"> {" "} </i>
                          Message Inbox
                        </Button>
                      </Col>
                      <Col sm="6">
                        <Button className="btn-icon-vertical btn-transition btn-transition-alt pt-2 pb-2"
                          outline color="danger">
                          <i className="pe-7s-ticket icon-gradient bg-love-kiss btn-icon-wrapper mb-2"> {" "} </i>
                          <b>Support Tickets</b>
                        </Button>
                      </Col>
                    </Row>
                  </div>
                  <Nav vertical>
                    <NavItem className="nav-item-divider" />
                    <NavItem className="nav-item-btn text-center">
                      <Button size="sm" className="btn-wide" color="primary">
                        Open Messages
                      </Button>
                    </NavItem>
                  </Nav> */}
                </DropdownMenu>
              </UncontrolledButtonDropdown>
            </div>
            <div className="widget-content-left  ms-3 header-user-info">
            <div className="widget-heading">{userName}</div>
            <div className="widget-subheading">{"Police Communication Officer"}</div>
            </div>
            <div className="widget-content-right header-user-info ms-3">
              <Button className="btn-shadow p-1" size="sm" onClick={notify2} color="info" id="Tooltip-1">
                <IoIosCalendar color="#ffffff" fontSize="20px" />
              </Button>
              <UncontrolledTooltip placement="bottom" target={"Tooltip-1"}>
                Click for Toastify Notifications!
              </UncontrolledTooltip>
            </div>
          </div>
        </div>
      </div>
    </Fragment>
  );
}

export default UserBox;
