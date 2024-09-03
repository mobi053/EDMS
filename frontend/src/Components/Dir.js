import React, { useEffect, useState, useCallback } from 'react';
import { Table, Button, Input, Spinner, ListGroup, ListGroupItem } from 'reactstrap';
import CustomPagination from './Pagination';
import { FaTrashAlt, FaEdit, FaEye } from "react-icons/fa"; 
import Swal from 'sweetalert2';
import { useHistory } from 'react-router-dom'; // Import useHistory

function Dir() {
  const [data, setData] = useState([]);
  const [loading, setLoading] = useState(true);
  const [currentPage, setCurrentPage] = useState(1);
  const [itemsPerPage] = useState(10);
  const [totalItems, setTotalItems] = useState(0);
  const [searchQuery, setSearchQuery] = useState("");
  const [suggestions, setSuggestions] = useState([]);
  const [showSuggestions, setShowSuggestions] = useState(false);

  const history = useHistory(); // Initialize the history function

  const fetchData = useCallback(() => {
    setLoading(true);
    const url = new URL('http://127.0.0.1:8000/api/view_dirs');
    url.searchParams.append('page', currentPage);
    url.searchParams.append('limit', itemsPerPage);
    if (searchQuery) {
      url.searchParams.append('search', searchQuery);
    }
    
    fetch(url)
      .then(response => response.json())
      .then(data => {
        setData(data.dir || []);
        setTotalItems(data.total || 0);
        setLoading(false);
      })
      .catch(error => {
        console.error('Error fetching data:', error);
        setLoading(false);
      });
  }, [currentPage, itemsPerPage, searchQuery]);

  useEffect(() => {
    fetchData();
  }, [fetchData]);

  const handleSearch = (event) => {
    const query = event.target.value;
    setSearchQuery(query);
    setCurrentPage(1);

    if (query.length > 2) {
      fetchSuggestions(query);
    } else {
      setSuggestions([]);
      setShowSuggestions(false);
    }
  };

  const fetchSuggestions = (query) => {
    fetch(`http://127.0.0.1:8000/api/view_dirs`)
      .then(response => response.json())
      .then(data => {
        setSuggestions(data.dir || []);
        setShowSuggestions(true);
      })
      .catch(error => {
        console.error('Error fetching suggestions:', error);
      });
  };

  const handleSuggestionClick = (suggestion) => {
    setSearchQuery(suggestion.name);
    setShowSuggestions(false);
    setCurrentPage(1);
    fetchData();
  };

  const handleDelete = async (id) => {
    const result = await Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!',
    });
  
    if (result.isConfirmed) {
      try {
        const response = await fetch(`http://127.0.0.1:8000/api/dirdelete/${id}`, {
          method: 'DELETE',
        });
  
        if (response.ok) {
          Swal.fire('Deleted!', 'User has been deleted.', 'success');
          fetchData();
        } else {
          Swal.fire('Error!', 'Failed to delete the user.', 'error');
        }
      } catch (error) {
        Swal.fire('Error!', 'An error occurred. Please try again.', 'error');
      }
    }
  };

  const handleEdit = (id) => {
    console.log(`Edit DIR with ID: ${id}`);
  };

  const handleView = (id) => {
    console.log(`View DIR with ID: ${id}`);
  };
  
  const handleMarkAsValid = async (id) => {
    try {
      const response = await fetch(`http://127.0.0.1:8000/api/is_valid`, {
        method: 'PUT', // or PUT based on your API design
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          id: id,
          dir_status: 2, // Assuming 2 is the status for valid
        }),
      });
  
      if (response.ok) {
        Swal.fire('Success!', 'Item marked as valid.', 'success');
        fetchData(); // Refresh the data to show the updated status
      } else {
        Swal.fire('Error!', 'Failed to mark the item as valid.', 'error');
      }
    } catch (error) {
      Swal.fire('Error!', 'An error occurred. Please try again.', 'error');
    }
  };
  

  const paginate = (pageNumber) => setCurrentPage(pageNumber);

  const totalPages = Math.ceil(totalItems / itemsPerPage);

  const handleAddDirClick = () => {
    history.push('/elements/add-dir'); // Use history.push to navigate to the "home" path
  };

  return (
    <div>
      <h1>View Dir</h1>
      <Input
        type="text"
        placeholder="Search by User Name or Email"
        value={searchQuery}
        onChange={handleSearch}
        className="mb-3"
      />
      {showSuggestions && (
        <ListGroup className="suggestions-list">
          {suggestions.map((suggestion, index) => (
            <ListGroupItem
              key={index}
              onClick={() => handleSuggestionClick(suggestion)}
              className="suggestion-item"
            >
              {suggestion.name}
            </ListGroupItem>
          ))}
        </ListGroup>
      )}
      {loading ? (
        <div className="text-center">
          <Spinner style={{ width: '3rem', height: '3rem' }} type="grow" />
          <div>Loading...</div>
        </div>
      ) : (
        <>
          <Button id="adddir" color="primary" className="m-2" onClick={handleAddDirClick}>
            Add DIR
          </Button>
          <Table hover className="mb-0">
            <thead>
              <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Dir_number</th>
                <th>Created Date</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              {data.map((item) => (
                <tr key={item.id} className={item.dir_status === 2 ? 'table-success' : ''}>
                  <td>{item.id}</td>
                  <td>{item.title}</td>
                  <td>{item.dir_number}</td>
                  <td>{item.camera_id}</td>
                  <td>
                    <Button
                      color="danger"
                      size="sm"
                      onClick={() => handleDelete(item.id)}
                      className="me-2"
                    >
                      <FaTrashAlt />
                    </Button>
                    <Button
                      color="primary"
                      size="sm"
                      onClick={() => handleEdit(item.id)}
                      className="me-2"
                    >
                      <FaEdit />
                    </Button>
                    <Button
                      color="info"
                      size="sm"
                      onClick={() => handleView(item.id)}
                    >
                      <FaEye />
                    </Button>
                    <Button
                      color="success" // Using success color to indicate a valid action
                      size="sm"
                      onClick={() => handleMarkAsValid(item.id)} // This function will mark the item as valid
                    >
                    <i className="bi bi-check2-circle"></i> {/* Checkmark icon */}
                    </Button>
                  </td>
                </tr>
              ))}
            </tbody>
          </Table>
          <CustomPagination
            currentPage={currentPage}
            totalPages={totalPages}
            onPageChange={paginate}
          />
        </>
      )}
    </div>
  );
}

export default Dir;
