import React, { useEffect, useState, useCallback } from 'react';
import { Table, Button, Input, Spinner, ListGroup, ListGroupItem } from 'reactstrap';
import CustomPagination from './Pagination';
import ModalExample from '../DemoPages/Components/Modal/Examples/Modal';
import { FaTrashAlt, FaEdit, FaEye } from "react-icons/fa"; // Import FontAwesome icons
import Swal from 'sweetalert2';


function Mobeen() {
  const [data, setData] = useState([]);
  const [loading, setLoading] = useState(true);
  const [currentPage, setCurrentPage] = useState(1);
  const [itemsPerPage] = useState(10);
  const [totalItems, setTotalItems] = useState(0);
  const [searchQuery, setSearchQuery] = useState("");
  const [suggestions, setSuggestions] = useState([]);
  const [showSuggestions, setShowSuggestions] = useState(false);

  const fetchData = useCallback(() => {
    setLoading(true);
    const url = new URL('http://127.0.0.1:8000/api/users');
    url.searchParams.append('page', currentPage);
    url.searchParams.append('limit', itemsPerPage);
    if (searchQuery) {
      url.searchParams.append('search', searchQuery);
    }
    
    fetch(url)
      .then(response => response.json())
      .then(data => {
        setData(data.users || []);
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
    setCurrentPage(1); // Reset to the first page on search

    if (query.length > 2) {
      fetchSuggestions(query);
    } else {
      setSuggestions([]);
      setShowSuggestions(false);
    }
  };

  const fetchSuggestions = (query) => {
    fetch(`http://127.0.0.1:8000/api/users`)
      .then(response => response.json())
      .then(data => {
        setSuggestions(data.users || []); // Updated to use data.users
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
    fetchData(); // Fetch data based on the selected suggestion
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
        const response = await fetch(`http://127.0.0.1:8000/api/destroy/${id}`, {
          method: 'DELETE',
        });
  
        if (response.ok) {
          Swal.fire('Deleted!', 'User has been deleted.', 'success');
         fetchData();
          // You might want to refresh the data here or remove the deleted item from the state
        } else {
          Swal.fire('Error!', 'Failed to delete the user.', 'error');
        }
      } catch (error) {
        Swal.fire('Error!', 'An error occurred. Please try again.', 'error');
      }
    }
  };

  const handleEdit = (id) => {
    // Implement edit functionality
    console.log(`Edit user with ID: ${id}`);
  };

  const handleView = (id) => {
    // Implement view functionality
    console.log(`View user with ID: ${id}`);
  };

  const paginate = (pageNumber) => setCurrentPage(pageNumber);

  const totalPages = Math.ceil(totalItems / itemsPerPage);

  return (
    <div>
      <h1>Mobeen Ashraf</h1>
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
          <ModalExample setData={setData} data={data}/>
          <Table hover className="mb-0">
            <thead>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Created Date</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              {data.map((item) => (
                <tr key={item.id}>
                  <td>{item.id}</td>
                  <td>{item.name}</td>
                  <td>{item.email}</td>
                  <td>{item.created_at}</td>
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

export default Mobeen;
