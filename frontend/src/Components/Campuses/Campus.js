import React, { useEffect, useState, useCallback } from 'react';
import { Table, Button, Input, Spinner, ListGroup, ListGroupItem, Dropdown, DropdownItem, DropdownMenu, DropdownToggle } from 'reactstrap';
import CustomPagination from '../Pagination';
import { FaTrashAlt, FaEdit, FaEye, FaCheck, FaFilter } from "react-icons/fa"; 
import Swal from 'sweetalert2';
import { useHistory, useLocation } from 'react-router-dom'; 
import ModalExample from '../../DemoPages/Components/Modal/Examples/Modal';
import {AddCampus} from './AddCapmus';

function Campus() {

  const location = useLocation();
  const queryParams = new URLSearchParams(location.search);
  const id = queryParams.get('id');

  const [sessionInfo, setSessionInfo] = useState(null);
  const [data, setData] = useState([]);
  const [usersName, setUsersName] = useState({});
  const [loading, setLoading] = useState(true);
  const [currentPage, setCurrentPage] = useState(1);
  const itemsPerPageOptions = [10, 20, 50, 100]; // Options for items per page
  const [itemsPerPage, setItemsPerPage] = useState(5); // Set default items per page
  const [dropdownOpen, setDropdownOpen] = useState(false);

  const [modalOpen, setModalOpen] = useState(false);
  const [modalData, setModalData] = useState([]);
  const [totalItems, setTotalItems] = useState(0);
  const [searchQuery, setSearchQuery] = useState("");
  const [suggestions, setSuggestions] = useState([]);
  const [showSuggestions, setShowSuggestions] = useState(false);
  const [editingColumn, setEditingColumn] = useState(null); // Which column is being edited (e.g., "name" or "teacher")
  const [searchTerms, setSearchTerms] = useState({
    name: '',
    teacher: ''
  });
  const handleHeaderDoubleClick = (column) => {
    setEditingColumn(column);
  };
  
  const history = useHistory(); 
  const userName = localStorage.getItem('userName');
  const userId = localStorage.getItem('userId');

  const toggleDropdown = () => setDropdownOpen(prevState => !prevState);
  const handleItemsPerPageChange = (value) => {  
    setItemsPerPage(value);
    setCurrentPage(1); // Reset to first page
  };

  const handleSearchChange = (e, column) => {
    const value = e.target.value;
    setSearchTerms((prev) => ({
      ...prev,
      [column]: value,
    }));
  };
  
  const filteredData = data.filter((item) => {
    const matchesName = item.name.toLowerCase().includes(searchTerms.name.toLowerCase());
    const matchesTeacher = item.teacher_in_charge_name.toLowerCase().includes(searchTerms.teacher.toLowerCase());
    return matchesName && matchesTeacher; // Adjust logic based on which columns are searched
  });
  
  // Fetch session info
  useEffect(() => {
    async function checkSession() {
      try {
        const response = await fetch(`http://dboard.psca.gop.pk/ppic3/get_user_info?id=${id}`);
        const data = await response.json();
        setUsersName(data);
        setSessionInfo(data);
        return data;
      } catch (error) {
        console.error('Error fetching session info:', error);
        return null;
      }
    }

    if (id) {
      checkSession().then(session => {
        if (!session || !session.userlevel) {
          history.push('/elements/Login');
        }
      });
    }
  }, [id, history]);

  // Fetch data
  const fetchData = useCallback(() => {
    setLoading(true);
    const url = new URL('http://127.0.0.1:8000/api/classes/view_classes');
    url.searchParams.append('page', currentPage);
    url.searchParams.append('limit', itemsPerPage); // Use the state value
    if (searchQuery) {
      url.searchParams.append('search', searchQuery);
    }
  
    fetch(url)
      .then(response => response.json())
      .then(data => {
        setData(data.class || []);
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

  // Handle search input and suggestions
  const handleSearch = (event) => {
    const query = event.target.value;
    setSearchQuery(query);
    setCurrentPage(1);

    if (query.length > 0) {
      fetchSuggestions(query);
    } else {
      setSuggestions([]);
      setShowSuggestions(false);
    }
  };
  
  const fetchSuggestions = (query) => {

    fetch(`http://127.0.0.1:8000/api/classes/view_classes?search=${query}`)
      .then(response => response.json())
      .then(data => {
        setSuggestions(data.class || []);
        setShowSuggestions(true);
      })
      .catch(error => {
        console.error('Error fetching suggestions:', error);
      });
  };

  const handleSuggestionClick = (suggestion) => {
    setSearchQuery(suggestion.teacher_in_charge_name);
    setShowSuggestions(false);
    setCurrentPage(1);
    fetchData();
  };

  // Handle delete
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
        const response = await fetch(`http://127.0.0.1:8000/api/classes/delete/${id}`, {
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

  // Handle edit
  const handleEdit = (id) => {
    history.push(`/elements/classes/edit-class/${id}`);
  };

  // Handle view
  const handleView = (item) => {
    setModalData(item);
    setModalOpen(true);
  };

  // Handle mark as valid
  const handleMarkAsValid = async (id) => {
    try {
      const response = await fetch(`http://127.0.0.1:8000/api/is_valid`, {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id: id, dir_status: 2 }),
      });

      if (response.ok) {
        Swal.fire('Success!', 'Item marked as valid.', 'success');
        fetchData();
      } else {
        Swal.fire('Error!', 'Failed to mark the item as valid.', 'error');
      }
    } catch (error) {
      Swal.fire('Error!', 'An error occurred. Please try again.', 'error');
    }
  };

  // Pagination
  const paginate = (pageNumber) => setCurrentPage(pageNumber);
  const totalPages = Math.ceil(totalItems / itemsPerPage);

  // Handle adding new class
  const handleAddDirClick = () => {
    history.push('/elements/classes/add-class');
  };

  return (
    <div>
      <h1>Classes</h1>

            {/* Items per Page Dropdown */}
          <Dropdown isOpen={dropdownOpen} toggle={toggleDropdown} className="mb-3">
            <DropdownToggle caret>
              Items per Page: {itemsPerPage}
            </DropdownToggle>
            <DropdownMenu>
              {itemsPerPageOptions.map(option => (
                <DropdownItem key={option} onClick={() => handleItemsPerPageChange(option)}>
                  {option}
                </DropdownItem>
              ))}
            </DropdownMenu>
          </Dropdown>

      <Input
        type="text"
        placeholder="Search by Class or Incharge Name"
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
               {suggestion.name} - {suggestion.teacher_in_charge_name}
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
          <Button color="primary" className="m-2" onClick={handleAddDirClick}>
            Add Class
          </Button>
          <Table hover className="mb-0">
            <thead>
              <tr>
              <th>ID</th>
              <th onDoubleClick={() => handleHeaderDoubleClick('name')}>
                {editingColumn === 'name' ? (
                  <Input
                    value={searchTerms.name}
                    onChange={(e) => handleSearchChange(e, 'name')}
                    placeholder="Search by Name"
                    onBlur={() => setEditingColumn(null)} // Exit editing mode on blur
                  />
                ) : (
                    <>
                      Name <FaFilter className="filter-icon" />
                    </>
                )}
              </th>
              <th onDoubleClick={() => handleHeaderDoubleClick('teacher')}>
                {editingColumn === 'teacher' ? (
                  <Input
                    value={searchTerms.teacher}
                    onChange={(e) => handleSearchChange(e, 'teacher')}
                    placeholder="Search by Teacher"
                    onBlur={() => setEditingColumn(null)} // Exit editing mode on blur
                  />
                ) : (
                    <>
                      Teacher In Charge <FaFilter className="filter-icon" />
                    </>                )}
              </th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
            {filteredData.map((item) => (
                <tr key={item.id} className={item.status === 2 ? 'table-success' : ''}>
                  <td>{item.id}</td>
                  <td>{item.name}</td>
                  <td>{item.teacher_in_charge_name}</td>
                  <td>{item.status}</td>
                  <td>
                    <Button color="danger" size="sm" onClick={() => handleDelete(item.id)} className="me-2">
                      <FaTrashAlt />
                    </Button>
                    <Button color="primary" size="sm" onClick={() => handleEdit(item.id)} className="me-2">
                      <FaEdit />
                    </Button>
                    <Button color="info" size="sm" onClick={() => handleView(item)} className="me-2">
                      <FaEye />
                    </Button>
                    <Button
                      color="success"
                      size="sm"
                      onClick={() => handleMarkAsValid(item.id)}
                      disabled={item.status === 2}
                    >
                      <FaCheck />
                    </Button>
                  </td>
                </tr>
              ))}
            </tbody>
          </Table>
          <CustomPagination currentPage={currentPage} totalPages={totalPages} onPageChange={paginate} />
        </>
      )}
      <ModalExample modalOpen={modalOpen} setModalOpen={setModalOpen} modalData={modalData} />
    </div>
  );
}

export default Campus;
