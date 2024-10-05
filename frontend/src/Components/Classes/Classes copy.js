import React, { useEffect, useState, useCallback } from 'react';
import { Table, Button, Input, Spinner, ListGroup, ListGroupItem, Dropdown, DropdownItem, DropdownMenu, DropdownToggle } from 'reactstrap';
import CustomPagination from '../Pagination';
import { FaTrashAlt, FaEdit, FaEye, FaCheck, FaFilter, FaFileExcel, FaFilePdf } from "react-icons/fa";
import Swal from 'sweetalert2';
import { useHistory, useLocation } from 'react-router-dom';
import ModalExample from '../../DemoPages/Components/Modal/Examples/Modal';
import ModalCampusView from '../../DemoPages/Components/Modal/Examples/ModalCampusView';
import '../mystyle.css';
import axios from 'axios';
import * as XLSX from 'xlsx';
import { jsPDF } from 'jspdf'; // Correct import for version 2.x
import 'jspdf-autotable';
import moment from 'moment';

function Classes() {

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
  // const [Status, setStatus]=useState(false)
  const [mode, setMode] = useState(""); // Add state for mode

  const [modalOpen, setModalOpen] = useState(false);
  const [modalData, setModalData] = useState([]);
  const [totalItems, setTotalItems] = useState(0);
  const [searchQuery, setSearchQuery] = useState("");
  const [suggestions, setSuggestions] = useState([]);
  const [showSuggestions, setShowSuggestions] = useState(false);
  const [editingColumn, setEditingColumn] = useState(null); // Which column is being edited (e.g., "name" or "teacher")
  const [searchFilterData, setSearchFilterData] = useState([]); // Data shown in the table
  const [selectedClass, setSelectedClass] = useState(''); // Selected class name
  const [startDate, setStartDate] = useState(''); // Start date filter
  const [endDate, setEndDate] = useState(''); // End date filter
  const [options, setOptions] = useState(''); // End date filter

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

  useEffect(()=>{
    const filteredData = data.filter((item) => { 
      const matchesName = item.name.toLowerCase().includes(searchTerms.name.toLowerCase());
      const matchesTeacher = item.teacher_in_charge_name.toLowerCase().includes(searchTerms.teacher.toLowerCase());
      return matchesName && matchesTeacher; // Adjust logic based on which columns are searched
    });
    if(searchQuery !== ''){
      setSearchFilterData(filteredData)
    }
    // console.log('filteredData',filteredData)
  },[searchFilterData, searchQuery])

  // console.log(searchFilterData, 'jhgjkdgbsdfg')

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
        setSearchFilterData(data.class || []);
        setTotalItems(data.total || 0);
        setLoading(false);
      })
      .catch(error => {
        console.error('Error fetching data:', error);
        setLoading(false);
      });
  }, [currentPage, itemsPerPage, searchQuery]);


  useEffect(() => {
    if(options !== 'filter'){
      fetchData();
    }
  }, [fetchData]);

  // Handle search input and suggestions
  const handleSearch = (event) => {
    const query = event.target.value;
    setSearchQuery(query);
    setCurrentPage(1);
    let body = {
      selectedClass: selectedClass || '',  // Send selectedClass if available
      startDate: startDate || '',          // Send startDate if available
      endDate: endDate || '',              // Send endDate if available
      page: 1,                   // Current page for pagination
      limit: itemsPerPage,                  // Limit of items per page
      search: query || ''
    };
    try{
      const response = axios.post('http://127.0.0.1:8000/api/classes/filter', body)
      console.log(response.data)
      setSearchFilterData(response.data.data);
      setTotalItems(response.data.total);      // Set the total number of items for pagination
      setCurrentPage(response.data.current_page);

    } catch(error){
      console.error(error)
    }

    // if (query.length > 0) {
    //   fetchSuggestions(query);
    // } else {
    //   setSuggestions([]);
    //   setShowSuggestions(false);
    // }
  };

  const fetchSuggestions = (query) => {

    // fetch(`http://127.0.0.1:8000/api/classes/view_classes?search=${query}`)
    //   .then(response => response.json())
    //   .then(data => {
    //     setSuggestions(data.class || []);
    //     setShowSuggestions(true);
    //   })
    //   .catch(error => {
    //     console.error('Error fetching suggestions:', error);
    //   });
  };

  // const handleSuggestionClick = (suggestion) => {
  //   setSearchQuery(suggestion.teacher_in_charge_name);
  //   setShowSuggestions(false);
  //   setCurrentPage(1);
  //   fetchData();
  // };

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
  const handleEdit = (mode, item) => {
    setMode(mode);
    setModalData(item);
    setModalOpen(true); 
    // history.push(`/elements/classes/edit-class/${item.id}`);
  };

  // Handle view
  const handleView = (mode, item) => {
    setMode(mode);

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
  const paginate = (pageNumber) => { setCurrentPage(pageNumber);
    if(selectedClass !== '' || startDate !== '' || endDate!== ''){
      searchFilter(pageNumber); // Fetch the filtered data for the new page
    }
    console.log(pageNumber)
  }
  const totalPages = Math.ceil(totalItems / itemsPerPage);

  // Handle adding new class
  const handleAddDirClick = (mode) => {
    setMode(mode);
    const emptyItem = {}; // Empty object for adding new data
    setModalData(emptyItem); // Set empty data for blank fields
    setModalOpen(true);
    
    // history.push('/elements/classes/add-class');
  };

  // Handle export to Excel
  const handleExport = (type) => {
    if (type === 'Excel') {
      const worksheet = XLSX.utils.json_to_sheet(searchFilterData); // Convert JSON data to sheet format
      const workbook = XLSX.utils.book_new();
      XLSX.utils.book_append_sheet(workbook, worksheet, "Classes");
      // Generate an Excel file and trigger download
      XLSX.writeFile(workbook, "classes_data.xlsx");
    } else if (type === 'Pdf') {
      const doc = new jsPDF(); // Create a new PDF document instance
      const tableColumn = ["ID", "Name", "Teacher In Charge", "Status"]; // Define column headers
      const tableRows = [];
  
      // Prepare table rows based on filtered data
      searchFilterData.forEach(item => {
        const rowData = [
          item.id,
          item.name,
          item.teacher_in_charge_name,
          item.status
        ];
        tableRows.push(rowData);
      });
  
      // Add the table to the PDF document
      doc.autoTable({
        head: [tableColumn],
        body: tableRows,
        startY: 20
      });
  
      // Add title to the PDF
      doc.text("Classes Data", 14, 15);
  
      // Save the generated PDF
      doc.save("classes_data.pdf");
    }
  };

   // Handle class selection
   const handleClassChange = (e) => {   
    setSelectedClass(e.target.value);
  };
  // Handle date change
  const handleDateChange = (e) => {
    if (e.target.name === 'sDate') {
      setStartDate(e.target.value);
    } else if (e.target.name === 'eDate') {
      setEndDate(e.target.value);
    }
  };

// Search filter function

const searchFilter = (pageNumber) => {
  // Clear any previous search queries
  setSearchQuery('');
  setOptions('filter')
  console.log(pageNumber, 'pageNumber')

  // Prepare the request body
  let body = {
    selectedClass: selectedClass || '',  // Send selectedClass if available
    startDate: startDate || '',          // Send startDate if available
    endDate: endDate || '',              // Send endDate if available
    page: pageNumber,                   // Current page for pagination
    limit: itemsPerPage,                  // Limit of items per page
    search: searchQuery || ''
  };


  // Send the request to filter data and paginate
  axios.post('http://127.0.0.1:8000/api/classes/filter', body)
    .then(response => {
      setSearchFilterData(response.data.data); // Set the filtered classes
      console.log('Filter response:', response.data);

      setTotalItems(response.data.total);      // Set the total number of items for pagination
      setCurrentPage(response.data.current_page); // Update current page
    })
    .catch(error => {
      console.error('Error fetching filtered data:', error);
    });
  //   const dateCreated = filtered[0].created_at.split('T')[0];
//   if (dateCreated >= startDate && dateCreated <= endDate) {
//     console.log('Yes, dateCreated is between startDate and endDate');
// } else {
//     console.log('No, dateCreated is not between startDate and endDate');
// }
  // setSearchFilterData(filtered); // Update the table with filtered data
};

// console.log('search Filter Data latest', searchFilterData)

  return (
    <div>
      <h1>Classes</h1>
      {/* Filter Section */}
      <div className='d-flex justify-content-between align-items-center col-md-6'>
        <select name='className' className='m-2' value={selectedClass} onChange={(e) => setSelectedClass(e.target.value)}>
          <option value=''>Please Select a class</option>
          {data.map(item => (
            <option key={item.id} value={item.name}>
              {item.name}
            </option>
          ))}
        </select>

        <Input type='date' name='sDate' className='m-2' value={startDate} onChange={(e) => setStartDate(e.target.value)} />
        <Input type='date' name='eDate' className='m-2' value={endDate} onChange={(e) => setEndDate(e.target.value)} />
        <Button color='primary' className='m-2' onClick={() => searchFilter(1)}>
          Search
        </Button>
      </div>
      <div className="d-flex justify-content-between align-items-center mb-3">
        <Dropdown isOpen={dropdownOpen} toggle={toggleDropdown}>
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
            {/* Add Export to Excel button */}
            <Button color="success" className="m-2" onClick={()=>handleExport('Excel')}>
            <FaFileExcel /> Excel
          </Button>
          <Button color="success" className="m-2" onClick={()=>handleExport('Pdf')}>
            <FaFilePdf /> Pdf
          </Button>
        </Dropdown>
        <div className="d-flex align-items-center">
            {/* <Button color="primary" className="m-2" onClick={handleAddDirClick}> */}
            <Button color="primary" className="m-2" onClick={() => handleAddDirClick('Add')}>
              Add Class
            </Button>
            <Input
                type="text"
                placeholder="Search here"
                value={searchQuery}
                onChange={handleSearch}
                className="input-container"
                style={{ width: '200px', marginRight: '10px' }} // Adjust the width as needed
            />
           
        </div>
      </div>
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
                    </>)}
                </th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              {searchFilterData && searchFilterData?.map((item, index) => (
                <tr key={item.id} className={item.status === 2 ? 'table-success' : ''}>
                  <td>{item.id}</td>
                  <td>{item.name}</td>
                  <td>{item.teacher_in_charge_name}</td>
                  <td>{item.status}</td>
                  <td>
                    <Button color="danger" size="sm" onClick={() => handleDelete(item.id)} className="me-2">
                      <FaTrashAlt />
                    </Button>
                    <Button color="primary" size="sm" onClick={() => handleEdit('Edit',item)} className="me-2">
                      <FaEdit />
                    </Button>
                    <Button color="info" size="sm" onClick={() => handleView('View',item)} className="me-2">
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
          <CustomPagination currentPage={currentPage} totalPages={totalPages} onPageChange={paginate} style={{ paddingTop: '15px' }} />
        </>
      )}
      {/* <ModalCampusView modalOpen={modalOpen} setModalOpen={setModalOpen} modalData={modalData} /> */}
      <ModalExample modalOpen={modalOpen} setModalOpen={setModalOpen} modalData={modalData} mode={mode} setModalData={setModalData} fetchData={fetchData} handleEdit={handleEdit}/>
    </div>
  );
}

export default Classes;
