import { React, useState, useEffect } from "react";
import { useLocation, useNavigate } from "react-router-dom";
import Button from "react-bootstrap/Button";
import Form from "react-bootstrap/Form";
import apiProducts from "../api/apiProducts";

export default function EditDynamicProduct() {
  let navigate = useNavigate();

  let { state } = useLocation();

  const [dynamicProperty, setDynamicProperty] = useState({});

  const [dto, setDto] = useState({
    property_name: "",
    property_value: "",
    static_product_id: state.staticProductId,
  });

  const handlePropertyName = (event) => {
    setDto({
      ...dto,
      ["property_name"]: event.target.value,
    });

    console.log(dto);
  };

  const handlePropertyValue = (event) => {
    setDto({
      ...dto,
      ["property_value"]: event.target.value,
    });
    console.log(dto);
  };

  useEffect(() => {
    apiProducts.getDynamicProductById(state.productId).then((data) => {
      setDynamicProperty(data);
      setDto["property_name"] = data["property_name"];
      setDto["property_value"] = data["property_value"];
      setDto["static_product_id"] = data["static_product_id"];
    });
  }, []);

  const onSubmit = (event) => {
    event.preventDefault();

    console.log(state.productId);

    const payload = dto;

    apiProducts
      .updateDynamicProperty(state.productId, payload)
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
          Update Dynamic Property
        </h1>
        <Form onSubmit={onSubmit}>
          <Form.Group className="mb-3" controlId="formBasicPropertyName">
            <Form.Label style={{ color: "#E7A572" }}>Property Name</Form.Label>
            <Form.Control
              type="text"
              placeholder="Enter Property Name"
              onChange={handlePropertyName}
              defaultValue={dynamicProperty["property_name"]}
            />
          </Form.Group>

          <Form.Group className="mb-3" controlId="formBasicPropertyValue">
            <Form.Label style={{ color: "#E7A572" }}>Property Value</Form.Label>
            <Form.Control
              type="text"
              placeholder="Enter Property Value"
              onChange={handlePropertyValue}
              defaultValue={dynamicProperty["property_value"]}
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
