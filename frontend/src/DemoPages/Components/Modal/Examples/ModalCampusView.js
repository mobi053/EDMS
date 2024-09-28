import React, { useState, useCallback } from "react";
import { Button, Modal, ModalHeader, ModalBody, ModalFooter, Table } from "reactstrap";
 
function ModalCampusView({modalOpen, setModalOpen, modalData}) {
 
  // console.log(modalData)
 
  const toggle = useCallback(() => {
    setModalOpen(prevModal => !prevModal);
  }, []);
 
  return (
    <span className="d-inline-block mb-2 me-2">
   
      <Modal isOpen={modalOpen} toggle={toggle} className={'abc'}>
        <ModalHeader toggle={toggle}>ModalCampusView</ModalHeader>
        <ModalBody>
          <Table>
            <thead>
              <tr>
                <th>Class Name</th>
                <th> Incharge Name</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>{modalData.name}</td>
                <td>{modalData.teacher_in_charge_name}</td>
              </tr>
            </tbody>    
          </Table>
        
        </ModalBody>
        <ModalFooter>
          <Button color="link" onClick={toggle}>
            Cancel
          </Button>
          <Button color="primary" onClick={toggle}>
            Do Something
          </Button>{" "}
        </ModalFooter>
      </Modal>
    </span>
  );
}
 
export default ModalCampusView;