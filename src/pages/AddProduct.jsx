import { React, useState, useEffect } from "react";
import { useLocation, useNavigate } from "react-router-dom";
import Button from "react-bootstrap/Button";
import Form from "react-bootstrap/Form";
import apiProducts from "../api/apiProducts";
import Row from "react-bootstrap/Row";
import Col from "react-bootstrap/Col";

export default function AddProduct() {
  let navigate = useNavigate();

  let { state } = useLocation();

  const [dto, setDto] = useState({
    property_name: "name",
    property_value: "",
  });

  const handlePropertyValue = (event) => {
    setDto({
      ...dto,
      ["property_value"]: event.target.value,
    });
  };

  const onSubmit = (event) => {
    event.preventDefault();

    const payload = dto;

    console.log(payload);

    apiProducts
      .addProduct(payload)
      .then((data) => {
        console.log(data);
      })
      .catch((error) => console.log(error));

    navigate(-1);
  };

  return (
    <>
      <div className="container form">
        <h1 className="mb-3" style={{ color: "#E7A572" }}>
          Add Product
        </h1>
        <Form onSubmit={onSubmit}>
          <Form.Group className="mb-3" controlId="formBasicPropertyName">
            <Form.Label style={{ color: "#E7A572" }}>Property Name</Form.Label>
            <Form.Control
              type="text"
              placeholder="Enter Property Name"
              value={"name"}
              disabled
            />
          </Form.Group>

          <Form.Group className="mb-3" controlId="formBasicPropertyValue">
            <Form.Label style={{ color: "#E7A572" }}>Property Value</Form.Label>
            <Form.Control
              type="text"
              placeholder="Enter Property Value"
              onChange={handlePropertyValue}
            />
          </Form.Group>
          <Button variant="primary" type="submit">
            Submit
          </Button>
        </Form>
      </div>
    </>
  );
}
