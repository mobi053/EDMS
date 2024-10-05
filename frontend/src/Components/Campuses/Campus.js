import React, { useEffect, useState, useCallback, Fragment } from 'react';
import { Table, Button, Input, Spinner, ListGroup, ListGroupItem, Dropdown, DropdownItem, DropdownMenu, DropdownToggle } from 'reactstrap';
import CustomPagination from '../Pagination';
import { FaTrashAlt, FaEdit, FaEye, FaCheck, FaFilter, FaFileExcel, FaFilePdf, } from "react-icons/fa";
import Swal from 'sweetalert2';
import { useHistory, useLocation } from 'react-router-dom';
import ModalExample from '../../DemoPages/Components/Modal/Examples/Modal';
import CampusModal from '../../DemoPages/Components/Modal/Examples/CampusModal';
import ModalCampusView from '../../DemoPages/Components/Modal/Examples/ModalCampusView';
import '../mystyle.css';
import axios from 'axios';
import * as XLSX from 'xlsx';
import { jsPDF } from 'jspdf'; // Correct import for version 2.x
import 'jspdf-autotable';
import moment from 'moment';
import { DataGrid } from '@mui/x-data-grid';
import DataTable from './example';
import { Paper } from '@mui/material';
import ReactDatePicker from 'react-datepicker';
import { InputGroup } from "reactstrap";
import { faCalendarAlt } from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { triggerExport } from '../exportUtils';

function Campuses() {

  const location = useLocation();
  const queryParams = new URLSearchParams(location.search);
  const id = queryParams.get('id');

  const [sessionInfo, setSessionInfo] = useState(null);
  const [data, setData] = useState([]);
  const [usersName, setUsersName] = useState({});
  const [loading, setLoading] = useState(true);
  const [currentPage, setCurrentPage] = useState(1);
  const itemsPerPageOptions = [10, 20, 50, 100]; // Options for items per page
  const [itemsPerPage, setItemsPerPage] = useState(10); // Set default items per page

  const [dropdownOpen, setDropdownOpen] = useState(false);
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
  const [paginationModel, setPaginationModel] = useState({ page: 0, pageSize: 10 });
  const [filterPaginationModel, setFilterPaginationModel] = useState({ page: 0, pageSize: 10 });
  const isFilterEmpty = selectedClass.length < 1 && startDate.length < 1 && endDate.length < 1;
  const [exportData, setExportData] = useState([])

  const [searchTerms, setSearchTerms] = useState({
    name: '',
    teacher: ''
  });
  // const handleHeaderDoubleClick = (column) => {
  //   setEditingColumn(column);
  // };

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

  useEffect(() => {
    const filteredData = data.filter((item) => {
      const matchesName = item.name.toLowerCase().includes(searchTerms.name.toLowerCase());
      const matchesTeacher = item.teacher_in_charge_name.toLowerCase().includes(searchTerms.teacher.toLowerCase());
      return matchesName && matchesTeacher; // Adjust logic based on which columns are searched
    });
    if (searchQuery !== '') {
      setSearchFilterData(filteredData)
    }
  }, [searchFilterData])


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
  // const fetchData = useCallback(() => {
  //   setLoading(true);
  //   const url = new URL('http://127.0.0.1:8000/api/classes/view_classes');
  //   url.searchParams.append('page', currentPage);
  //   url.searchParams.append('limit', itemsPerPage); // Use the state value
  //   if (searchQuery) {
  //     url.searchParams.append('search', searchQuery);
  //   }

  //   fetch(url)
  //     .then(response => response.json())
  //     .then(data => {
  //       setData(data.class || []);
  //       setSearchFilterData(data.class || []);
  //       setTotalItems(data.total || 0);
  //       setLoading(false);
  //     })
  //     .catch(error => {
  //       console.error('Error fetching data:', error);
  //       setLoading(false);
  //     });
  // }, [currentPage, itemsPerPage, searchQuery]);


  // useEffect(() => {
  //   if(options !== 'filter'){
  //     fetchData();
  //   }
  // }, [fetchData]);



  // Handle search input and suggestions
  const handleSearch = async (pageNumber, e) => {
    const searchValue = e.target.value;
    setSearchQuery(searchValue); // Set the search query  
    // Prepare the request body
    const body = {
      selectedClass: selectedClass || '',
      startDate: startDate || '',
      endDate: endDate || '',
      page: pageNumber + 1, // Increment for 1-based API
      limit: itemsPerPage,
      search: searchValue || '',
    };

    // Log the state before proceeding

    try {
      const url = isFilterEmpty
        ? 'http://127.0.0.1:8000/api/classes/view_classes'
        : `http://127.0.0.1:8000/api/classes/filter`;

      const params = isFilterEmpty
        ? {
          page: pageNumber + 1, // 1-based page number for the API
          limit: paginationModel.pageSize,
          search: e.target.value
        }
        : body; // Use the body directly for the POST request

      // Make the API call
      const response = isFilterEmpty
        ? await axios.get(url, { params })
        : await axios.post(url, params);

      // Set the data and total items based on the response
      setData(isFilterEmpty ? response.data.class || [] : response.data.class || []);
      setTotalItems(isFilterEmpty ? response.data.total || 0 : response.data.total || 0);

    } catch (error) {
      console.error('Error fetching filtered data:', error);
    }
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

          fetchData(paginationModel.page, paginationModel.pageSize); // Refetch data after deletion
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
  const paginate = (pageNumber) => {
    setCurrentPage(pageNumber);
    if (selectedClass !== '' || startDate !== '' || endDate !== '') {
      searchFilter(pageNumber); // Fetch the filtered data for the new page
    }
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
  const handleExport = async (type) => {
    const searchBoxValue = searchQuery || '';
    try {
      const body = {
        selectedClass: selectedClass || '',
        startDate: startDate || '',
        endDate: endDate || '',
        page: 'all', // Increment for 1-based API
        // limit: itemsPerPage,
        search: searchQuery || '',
      };
      const url = isFilterEmpty
        ? 'http://127.0.0.1:8000/api/classes/view_classes'
        : `http://127.0.0.1:8000/api/classes/filter`;

      const params = isFilterEmpty
        ? {
          page: 'all', // 1-based page number for the API
          // limit: paginationModel.pageSize,
          search: searchBoxValue
        }
        : body; // Use the body directly for the POST request
      const response = isFilterEmpty
        ? await axios.get(url, { params })
        : await axios.post(url, params);
      setExportData(response.data.class)
      triggerExport(type, response.data.class, columns);
    } catch (error) {
      console.error('Error fetching filtered data:', error);
    }
  };
  // const triggerExport = (type, exportData) => {
  //   if (!exportData || exportData.length === 0) {
  //     console.warn('No data to export');
  //     return;
  //   }
  //   if (type === 'Excel') {
  //     const worksheet = XLSX.utils.json_to_sheet(exportData); // Convert JSON data to sheet format
  //     const workbook = XLSX.utils.book_new();
  //     XLSX.utils.book_append_sheet(workbook, worksheet, "Classes");
  //     // Generate an Excel file and trigger download
  //     XLSX.writeFile(workbook, "classes_data.xlsx");
  //   } else if (type === 'Pdf') {
  //     const doc = new jsPDF(); // Create a new PDF document instance
  //     const tableColumn = ["ID", "Name", "Teacher In Charge", "Status"]; // Define column headers
  //     const tableRows = [];

  //     // Prepare table rows based on filtered data
  //     exportData.forEach(item => {
  //       const rowData = [
  //         item.id,
  //         item.name,
  //         item.teacher_in_charge_name,
  //         item.status
  //       ];
  //       tableRows.push(rowData);
  //     });

  //     // Add the table to the PDF document
  //     doc.autoTable({
  //       head: [tableColumn],
  //       body: tableRows,
  //       startY: 20
  //     });

  //     // Add title to the PDF
  //     doc.text("Classes Data", 14, 15);

  //     // Save the generated PDF
  //     doc.save("classes_data.pdf");
  //   };
  // }

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



  // Columns definition for DataGrid
  const columns = [
    { field: 'id', headerName: 'ID', width: 90 },
    { field: 'name', headerName: 'Name', width: 200 },
    { field: 'principal', headerName: 'Principal', width: 200 },
    { field: 'location', headerName: 'Location', width: 130 },
    {
      field: 'actions',
      headerName: 'Actions',
      width: 300,
      renderCell: (item) => (
        <>
          <Button color="danger" size="sm" onClick={() => handleDelete(item.row.id)} className="me-2">
            <FaTrashAlt />
          </Button>
          <Button color="primary" size="sm" onClick={() => handleEdit('Edit', item.row)} className="me-2">
            <FaEdit />
          </Button>
          <Button color="info" size="sm" onClick={() => handleView('View', item.row)} className="me-2">
            <FaEye />
          </Button>
          <Button color="success" size="sm" disabled={item.row.status === 1}>
            <FaCheck />
          </Button>
        </>
      ),
    },
  ];
  const [filteredPage, setFilteredPage] = useState(0)

  const searchFilter = async (pageNumber) => {
    setSearchQuery('');
    // console.log(pageNumber, 'pageNumberrrr')
    // Prepare the request body
    const body = {
      selectedClass: selectedClass || '',
      startDate: startDate || '',
      endDate: endDate || '',
      page: pageNumber.page + 1, // Increment for 1-based API
      limit: pageNumber.pageSize ? pageNumber.pageSize : itemsPerPage,
      search: searchQuery || '',
    };

    try {
      const response = await axios.post('http://127.0.0.1:8000/api/classes/filter', body);
      setData(response.data.class); // Set the filtered classes
      setTotalItems(response.data.total); // Set the total number of items for pagination
      // console.log('Filtered Data', startDate);

    } catch (error) {
      console.error('Error fetching filtered data:', error);
    }
  };
  // console.log(paginationModel, 'pagination modell>>>>>>>>>>>>>>>>')
  const fetchData = async (page, size, modalPage) => {
    setLoading(true); // Set loading state before fetching
    const currentPage = modalPage !== undefined ? modalPage : page + 1;
    // setCurrentPage(modalPage);
    // if (isNaN(page)) {
    //   page = currentPage;
    //   size = 10;
    //   setPaginationModel({ page: currentPage, pageSize: size });
    // }
    // console.log(currentPage, "Current PAge", size, "SIZE")
    try {
      const response = await axios.get('http://127.0.0.1:8000/api/campuses/view_campuses', {
        params: {
          page: currentPage, // 1-based page number for the API
          limit: size,
        },
      });

      setData(response.data.campuses || []); // Adjust the data structure based on the response
      setTotalItems(response.data.total || 0); // Adjust the total count
    } catch (error) {
      console.error('Error fetching data:', error);
    } finally {
      setLoading(false); // Turn off loading state
    }
  };

  // Fetch data whenever page or page size changes
  useEffect(() => {

    isFilterEmpty ? fetchData(paginationModel.page, paginationModel.pageSize) : searchFilter(filteredPage)
  }, [filterPaginationModel, filteredPage]);


  const view_classes = async (newModel) => {

    // If empty, call fetchData
    setPaginationModel(newModel);
    await fetchData(newModel.page, newModel.pageSize);
  }

  const filteredFunction = async (newModel) => {
    console.log('newModal', newModel)
    setFilterPaginationModel(newModel);
    setFilteredPage(newModel); // Update filtered page state
    await searchFilter(newModel);
  }

  const handlePaginationChange = async (newModel) => {
    setLoading(true); // Start loading when pagination changes
    // Check if filter parameters are empty
    console.log(newModel, 'newModal')
    isFilterEmpty ? view_classes(newModel) : filteredFunction(newModel)
    // setCurrentPage(currentPage+1);  
    setLoading(false); // Stop loading after fetching data
  };
  const rowHeight = 52; // Default row height in DataGrid
  let calculatedHeight;

  if (data.length === 0) {
    calculatedHeight = Math.min(data.length * rowHeight + 150, 700);
  } else {
    calculatedHeight = Math.min(data.length * rowHeight + 110, 700);
  }


  return (
    <div>
      <h1>Campuses</h1>
      {/* Filter Section */}
      <div className='d-flex justify-content-between align-items-center col-md-6'>
        <Input className="m-2" type="select" name='className' value={selectedClass} onChange={(e) => setSelectedClass(e.target.value)}>
          <option value=''>Please Select a class</option>
          {data.map(item => (
            <option key={item.id} value={item.name}>
              {item.name}
            </option>
          ))}
        </Input>
        <InputGroup>
          <div className="input-group-text">
            <FontAwesomeIcon icon={faCalendarAlt} />
          </div>
          <ReactDatePicker selected={startDate} onChange={(date) => setStartDate(date)} placeholderText="Click to select a date" className="form-control" />
        </InputGroup>
        <InputGroup className="p-2">
          <div className="input-group-text">
            <FontAwesomeIcon icon={faCalendarAlt} />
          </div>
          <ReactDatePicker selected={endDate} onChange={(date) => setEndDate(date)} placeholderText="Click to select a date" className="form-control" />
        </InputGroup>
        {/* <Input type='date' name='sDate' className='m-2' value={startDate} onChange={(e) => setStartDate(e.target.value)} /> */}
        {/* <Input type='date' name='eDate' className='m-2' value={endDate} onChange={(e) => setEndDate(e.target.value)} /> */}
        <Button color='primary' className='m-2' onClick={() => filteredFunction(0)}>
          Search
        </Button>
      </div>
      <div className="d-flex justify-content-between align-items-center mb-3">
        <Dropdown isOpen={dropdownOpen} toggle={toggleDropdown}>
          {/* <DropdownToggle caret>
            Items per Page: {itemsPerPage}
          </DropdownToggle> */}
          <DropdownMenu>
            {itemsPerPageOptions.map(option => (
              <DropdownItem key={option} onClick={() => handleItemsPerPageChange(option)}>
                {option}
              </DropdownItem>
            ))}
          </DropdownMenu>
          {/* Add Export to Excel button */}
          <Button color="success" className="m-2" onClick={() => handleExport('Excel')}>
            <FaFileExcel /> Excel
          </Button>
          <Button color="success" className="m-2" onClick={() => handleExport('Pdf')}>
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
            onChange={(e) => { handleSearch(0, e) }}
            className="input-container"
            style={{ width: '200px', marginRight: '10px' }} // Adjust the width as needed
          />

        </div>
      </div>

      {loading ? (
        <div className="text-center">
          <Spinner style={{ width: '3rem', height: '3rem' }} type="grow" />
          <div>Loading...</div>
        </div>
      ) : (
        <>
          <div style={{ height: 'fit-content', width: '100%' }}>
            <Paper sx={{ height: 'fit-content', width: '100%' }}>
              <div style={{ height: `${calculatedHeight}px`, width: '100%' }}>
                <DataGrid
                  rows={data}
                  columns={columns} // Make sure you define your columns
                  rowCount={totalItems}
                  loading={loading}
                  pageSizeOptions={[5, 10, 20]}
                  paginationMode="server" // Enable server-side pagination
                  paginationModel={isFilterEmpty ? paginationModel : filterPaginationModel} // Use correct pagination model
                  onPaginationModelChange={handlePaginationChange} // Handle page change
                  sx={{ border: 0 }}
                />
              </div>
            </Paper>
          </div>


          {/* <CustomPagination currentPage={currentPage} totalPages={totalPages} onPageChange={paginate} style={{ paddingTop: '15px' }} /> */}
        </>
      )}
      {/* <ModalCampusView modalOpen={modalOpen} setModalOpen={setModalOpen} modalData={modalData} /> */}
      <CampusModal modalOpen={modalOpen} setModalOpen={setModalOpen} modalData={modalData} mode={mode} setModalData={setModalData} fetchData={fetchData} handleEdit={handleEdit} currentPage={paginationModel.page} />
    </div>
  );
}

export default Campuses;
