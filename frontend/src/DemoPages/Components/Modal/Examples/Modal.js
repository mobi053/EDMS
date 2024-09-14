import React, { useState, useCallback } from "react";
import { Button, Modal, ModalHeader, ModalBody, ModalFooter } from "reactstrap";
 
function ModalExample({modalOpen, setModalOpen, modalData}) {
 
  console.log(modalOpen)
 
  const toggle = useCallback(() => {
    setModalOpen(prevModal => !prevModal);
  }, []);
 
  return (
    <span className="d-inline-block mb-2 me-2">
   
      <Modal isOpen={modalOpen} toggle={toggle} className={'abc'}>
        <ModalHeader toggle={toggle}>Modal title</ModalHeader>
        <ModalBody>
          {modalData.title}
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
 
export default ModalExample;