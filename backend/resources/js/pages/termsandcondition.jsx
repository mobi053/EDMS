import React from "react";
import { useState, useEffect } from "react";
import { Link } from "react-router-dom";
import axios from "axios";
import NavbarSearch from "../components/layout/partials/navbarSearch";
import MainNavbar from "../components/layout/partials/mainNavbar";
import MainFooter from "../components/layout/partials/mainFooter";
import HomeSignup from "../components/layout/partials/homeSignup";
import HomeShopCart from "../components/layout/partials/homeShopCart";
import { Container, Card } from "react-bootstrap";

import { Bars } from "react-loader-spinner";
function TermsAndConditions() {
    const [loading, setLoading] = useState(false);
    return (
        <>
            <Bars
                height="80"
                width="80"
                color="#4fa94d"
                ariaLabel="bars-loading"
                wrapperStyle={{}}
                wrapperClass="loading-spinner-overlay"
                visible={loading}
            />
            <div className="border-bottom ">
                <NavbarSearch />
                <MainNavbar />
            </div>
            {/* Modal */}
            <HomeSignup />
            {/* Shop Cart */}
            <HomeShopCart />

            <div
                className="container mt-4"
                style={{
                    backgroundColor: "lightgray",
                    borderRadius: "5px",
                    paddingTop: "5px",
                    paddingBottom: "2px",
                }}
            >
                <h2>The Fence Line Terms and Conditions of Sale</h2>
                <p>Our terms and conditions are all shown below.</p>
            </div>
            <div className="container mt-4">
                <p>
                    Please note that we are a trade supplier dealing direct with
                    specialist fencing companies, agricultural merchants and
                    retail outlets. For private customers please do contact us
                    and we will be pleased to introduce you to one of our trade
                    outlets who will be able to supply your needs both small and
                    large.
                </p>
                <p>
                    For potential new customers wishing to open a trade credit
                    account please get in touch and we will send out an
                    application form to you together with our full terms and
                    conditions of sale.
                </p>
                <p>
                    All product and services are supplied strictly subject to
                    our standard Terms and Conditions of Sale shown below ...
                </p>

                <h3>CONDITIONS OF SALE</h3>
                <p>
                    Any contract of sale between this company and a customer
                    will be subject to these conditions and the placing of an
                    order with this company shall be deemed to be an acceptance
                    by the customer of these conditions. Any terms or conditions
                    appearing in any document issued by the customer shall have
                    no effect. No variation of any of these conditions shall be
                    binding on this company unless expressly accepted by this
                    company in writing.
                </p>
                <h3>PRICE</h3>
                <p>
                    Prices to be charged will be those ruling at the date of the
                    despatch of the material, unless otherwise stated. Prices
                    given in any quotation are those ruling at the date of the
                    quotation and are given for guidance only. All prices are
                    subject to alteration without notice.
                </p>
                <h3>PAYMENT</h3>
                <p>
                    Unless otherwise stated in the contract the price of each
                    delivery shall be paid by the last day of the month
                    following the month in which the goods were despatched. If
                    any such payment shall not be made on the due date the
                    company shall be entitled to charge interest on such sum at
                    the rate of 2.5% above the current bank rate.
                </p>
                <h3>DELIVERY</h3>
                <p>
                    The rate or time of delivery in relation to any consignment
                    or series of consignments is estimated as accurately as
                    possible. This company will do its best to meet the
                    requirements of the customer as to time of delivery as
                    specified in the customer's enquiry but no guarantee or
                    warranty as to time of delivery or rate of deliveries is
                    given or implied.
                </p>
                <h3>DELIVERIES TO SITES</h3>
                <p>
                    Where customers request deliveries to sites on or by a
                    specific date, this company will do its best to meet such
                    requirements but the company cannot give any guarantee nor
                    can any claims be accepted on account of late deliveries.
                    This is because our transport service, although normally
                    reliable, is subject to various contingencies beyond our
                    control, including road and weather conditions, breakdowns,
                    accidents, delay in unloading at customer's premises, etc.
                    Furthermore, we are sometimes in the hands of outside
                    transport contractors over whom we do not have direct
                    control. Customers are strongly advised, therefore, not to
                    send labour to sites without first ensuring that the goods
                    have been delivered to the desired location.
                </p>
                <h3>RETURNS/REFUNDS</h3>
                <p>
                    If you are unhappy with your purchase, please return it to
                    us within 14 days. We will make a refund, provided the goods
                    are returned in perfect condition and in their original
                    packaging. Please return the delivery note with the item and
                    state the reason for the return. Please note we do not
                    refund postage costs unless an item arrives damaged due to
                    our negligence.
                </p>
                <p>
                    Items lost or damaged in the post that have been packed
                    correctly are usually insured, we will fill out any
                    necessary claims forms at the post office on your behalf and
                    liaise with the correct postal service to achieve a
                    satisfactory outcome on your behalf. In the event that this
                    becomes necessary please be aware a refund will be made as
                    soon as we have clearance from the Royal Mail/Courier, this
                    can take several weeks but we will endeavour to keep you
                    informed of all developments as appropriate.
                </p>
                <p>
                    If you have a faulty item on delivery please contact us and
                    we will arrange a replacement to be sent out as soon as
                    possible. If your item becomes faulty during its warranty
                    period please refer to your warranty card or contact us via
                    email for assistance. Please click here to send an email
                    informing us of your issue alternatively please contact us
                    by telephone 01507 600 666, you should be prepared to quote
                    your order reference or invoice number to minimise any
                    delays in processing your returns.
                </p>
                <h3>DAMAGE OR LOSS IN TRANSIT</h3>
                <p>
                    This company will not accept responsibility for material
                    damage or lost in transit, unless this company and the
                    carriers are notified of the complaint in writing, within
                    three days of the receipt, by the customer of the
                    consignment in respect of which damage or shortage is
                    alleged. And an adequate opportunity is given for inspection
                    of the material in the case of non-delivery of a complete
                    consignment notification must be made in writing within 21
                    days of the date shown on the advise or delivery note. In
                    any event the liability of this company in respect of
                    material damage or loss in transit, shall be limited to the
                    cost of replacement of the loss or damage material and in
                    the case of damaged goods shall be the subject to such goods
                    being returned to this company at the risk and expense of
                    the customer.
                </p>
                <h3>DEFECTIVE MATERIAL</h3>
                <p>
                    This Company shall not be liable to the customer for any
                    consequential or special loss or damage or any loss of
                    profit suffered by the customer by reason of any defect or
                    errors in quality or measurement of goods supplied.
                </p>
                <p>
                    Any goods returned to this company by the customer at its
                    own expense within seven days of the receipt, thereof by the
                    customer, and which are found on examination by this company
                    to be defective in quality or measurements. Will be replaced
                    by this company free of charge but that will be the limit of
                    this company's liability.
                </p>
                <h3>CUSTOMERS MATERIAL</h3>
                <p>
                    If this company agrees to carry out work on customer's own
                    material, or to store customers' goods after an invoice has
                    been presented for the goods. Such material or goods will be
                    held at the customer's risk and this company will not be
                    responsible for the damage by accident, fire, flood,
                    deterioration or any other cause.
                </p>
                <h3>GUARANTEES AND WARRANTIES</h3>
                <p>
                    Any condition warranty guarantee or statement as to the
                    quality of any material or its fitness for any purpose
                    whether express or implied by statute by the common law or
                    by any custom of trade or otherwise is hereby excluded
                    unless given expressly in writing by this company.
                </p>
                <h3>CANCELLATION</h3>
                <p>
                    Under no circumstances may an order be cancelled except on
                    terms to be agreed in writing with this company.
                </p>
                <h3>FORCE MAJEURE</h3>
                <p>
                    If the manufacture or delivery of any material ordered by
                    the customer, shall be prevented or delayed, directly or
                    indirectly by fire, weather conditions, war (whether
                    formerly declared or not) civil disturbance, strikes,
                    industrial dispute or shortage of materials, or by any other
                    cause outside the complete control of this company. This
                    company shall be entitled to extend the period for the
                    delivery of the materials for such reasonable period as may
                    in the opinion of the company be sufficient to enable the
                    delivery to be made. If this company does so elect, the
                    buyer shall not be entitled to cancel the contract nor to
                    receive any compensation of the resultant delay.
                </p>
                <h3>DELIVERY BY INSTALMENTS</h3>
                <p>
                    Where under the terms of any contract delivery of material
                    to a customer is made by instalments whether in accordance
                    with a pre-arranged programme or not the following
                    provisions shall apply. This company shall be entitled,
                    without prejudice to any other right to terminate the
                    contract or to suspend further deliveries there under in any
                    of the following events. If any sum due and payable to this
                    company by the customer is unpaid If the customer shall
                    without due cause have failed to take delivery of any goods
                </p>
                <p>
                    If the customer has failed to provide any latter of credit
                    bill of exchange or other security required by the contract
                    If the customer becomes insolvent, or goes into liquidation,
                    whether voluntary or compulsory, (except a voluntary
                    liquidation for the purpose of amalgamation or
                    reconstruction only) or has a Receiver appointed, or if the
                    customer is an individual or a partnership, has entered into
                    any arrangement with his or their creditors or has had a
                    receiving order in bankruptcy made against him or them. No
                    default by this company in respect of any instalment shall
                    entitle the customer to determine the contract or to treat
                    it as having been repudiated in regard to any instalments
                    remaining to be delivered under the terms of this contract.
                </p>
                <h3>PROPERTY TRANSFER</h3>
                <p>
                    Property in these goods shall only pass to the customer from
                    the date of payment in full, of all sums payable to the
                    company in respect thereof. Until such time the goods remain
                    the absolute property of the company. In default of payment
                    by the customer when lawfully demanded by the company, the
                    company shall be entitled to enter the premises of the
                    customer and recover the goods.
                </p>
            </div>

            <MainFooter />
        </>
    );
}
export default TermsAndConditions;
