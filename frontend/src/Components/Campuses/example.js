import * as React from 'react';
import { DataGrid } from '@mui/x-data-grid';
import Paper from '@mui/material/Paper';
import { useEffect, useState } from 'react';
import axios from 'axios'; // Make sure you have axios installed

const columns = [
  { field: 'id', headerName: 'ID', width: 70 },
  { field: 'name', headerName: 'Class Name', width: 150 },
  { field: 'teacher_in_charge_name', headerName: 'Teacher', width: 180 },
  { field: 'status', headerName: 'Status', width: 100 },
//   {
//     field: 'created_at',
//     headerName: 'Created At',
//     type: 'dateTime',
//     width: 200,
//   },
];

export default function DataTable() {
  const [rows, setRows] = useState([]);
  const [loading, setLoading] = useState(true);
  const [totalItems, setTotalItems] = useState(0); // To store the total number of records
  const [paginationModel, setPaginationModel] = useState({ page: 0, pageSize: 5 });

  const fetchData = async (page, size) => {
    setLoading(true); // Set loading state before fetching
    try {
      const response = await axios.get('http://127.0.0.1:8000/api/classes/view_classes', {
        params: {
          page: page + 1, // 1-based page number for the API
          limit: size,
        },
      });

      // Transform the data to match the required structure
      const formattedRows = response.data.class.map((item) => ({
        id: item.id,
        name: item.name,
        teacher_in_charge_name: item.teacher_in_charge_name,
        status: item.status === 1 ? 'Active' : 'Inactive',
      }));
      
      setRows(response.data.class);
      setTotalItems(response.data.total || 0); // Set the total number of records for pagination
    } catch (error) {
      console.error('Error fetching data:', error);
      // Optionally handle error here
    } finally {
      setLoading(false); // Turn off loading state
    }
  };

  useEffect(() => {
    fetchData(paginationModel.page, paginationModel.pageSize); // Fetch data whenever page or size changes
  }, [paginationModel]);

  return (
    <Paper sx={{ height: 400, width: '100%' }}>
      <DataGrid
        rows={rows}
        columns={columns}
        rowCount={totalItems}
        loading={loading}
        pageSizeOptions={[5, 10]}
        paginationMode="server" // Enable server-side pagination
        paginationModel={paginationModel}
        onPaginationModelChange={(newModel) => setPaginationModel(newModel)} // Update pagination model when changed
        sx={{ border: 0 }}
      />
    </Paper>
  );
}
