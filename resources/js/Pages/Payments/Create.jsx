import LmsLayout from '@/Layouts/LmsLayout';
import { Head, useForm, Link } from '@inertiajs/react';

const cardStyle = {
    background: '#fff',
    borderRadius: '16px',
    boxShadow: '0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03)',
    padding: '32px',
    border: '1px solid #f1f5f9',
};

const inputStyle = {
    width: '100%',
    padding: '12px 16px',
    background: '#f8fafc',
    border: '1px solid #e2e8f0',
    borderRadius: '12px',
    fontSize: '14px',
    color: '#1e293b',
    outline: 'none',
    transition: 'all 0.2s',
};

export default function PaymentCreate({ auth, fees }) {
    const { data, setData, post, processing, errors } = useForm({
        fee_id: '',
        amount: '',
    });

    const selectedFee = fees.find(f => f.id === parseInt(data.fee_id));
    const maxAmount = selectedFee ? (selectedFee.total_amount - selectedFee.paid_amount) : 0;

    const submit = (e) => {
        e.preventDefault();
        post(route('payments.store'));
    };

    return (
        <LmsLayout title="Initiate Payment">
            <Head title="Make Payment - EduLMS" />

            <div className="row justify-content-center">
                <div className="col-12 col-lg-8">
                    <div style={{ marginBottom: '32px' }}>
                        <h2 style={{ fontSize: '28px', fontWeight: 900, color: '#1e293b', marginBottom: '8px' }}>Payment Gateway</h2>
                        <p style={{ fontSize: '15px', color: '#64748b' }}>Select a fee and enter the amount to pay via PhonePe.</p>
                    </div>

                    <form onSubmit={submit}>
                        <div style={cardStyle}>
                            <div style={{ display: 'flex', alignItems: 'center', gap: '16px', marginBottom: '32px', padding: '16px', background: '#f0f9ff', borderRadius: '12px', border: '1px solid #e0f2fe' }}>
                                <div style={{ width: '48px', height: '48px', borderRadius: '12px', background: '#fff', display: 'flex', alignItems: 'center', justifyContent: 'center', boxShadow: '0 2px 4px rgba(0,0,0,0.05)' }}>
                                    <img src="https://www.phonepe.com/badges/phonepe-logo.png" alt="PhonePe" style={{ width: '32px' }} onError={(e) => { e.target.style.display='none'; e.target.nextSibling.style.display='block'; }} />
                                    <i className="bi bi-wallet2" style={{ display: 'none', color: '#5f259f', fontSize: '24px' }}></i>
                                </div>
                                <div>
                                    <div style={{ fontSize: '15px', fontWeight: 800, color: '#0369a1' }}>PhonePe Secure Payment</div>
                                    <div style={{ fontSize: '12px', color: '#0ea5e9' }}>UPI, Credit/Debit Cards, Net Banking</div>
                                </div>
                            </div>

                            <div className="row g-4">
                                <div className="col-12">
                                    <label style={{ display: 'block', fontSize: '13px', fontWeight: 700, color: '#475569', marginBottom: '8px', textTransform: 'uppercase' }}>Select Outstanding Fee</label>
                                    <select 
                                        value={data.fee_id} 
                                        onChange={e => setData('fee_id', e.target.value)} 
                                        required 
                                        style={inputStyle}
                                    >
                                        <option value="">-- Choose Course Fee --</option>
                                        {fees.map(f => (
                                            <option key={f.id} value={f.id} disabled={f.status === 'paid'}>
                                                {f.course?.title} (Due: ₹{(f.total_amount - f.paid_amount).toLocaleString()})
                                            </option>
                                        ))}
                                    </select>
                                    {errors.fee_id && <div style={{ color: '#ef4444', fontSize: '12px', marginTop: '4px' }}>{errors.fee_id}</div>}
                                </div>

                                <div className="col-12">
                                    <label style={{ display: 'block', fontSize: '13px', fontWeight: 700, color: '#475569', marginBottom: '8px', textTransform: 'uppercase' }}>Amount to Pay (₹)</label>
                                    <div style={{ position: 'relative' }}>
                                        <div style={{ position: 'absolute', left: '16px', top: '50%', transform: 'translateY(-50%)', fontWeight: 700, color: '#94a3b8' }}>₹</div>
                                        <input 
                                            type="number" 
                                            value={data.amount} 
                                            onChange={e => setData('amount', e.target.value)} 
                                            required 
                                            style={{ ...inputStyle, paddingLeft: '32px' }}
                                            placeholder="0.00"
                                            max={maxAmount}
                                            min="1"
                                        />
                                    </div>
                                    {selectedFee && (
                                        <div style={{ marginTop: '8px', fontSize: '12px', color: '#64748b', display: 'flex', gap: '8px' }}>
                                            <button type="button" onClick={() => setData('amount', maxAmount)} style={{ background: 'none', border: 'none', color: '#2563eb', fontWeight: 700, padding: 0, cursor: 'pointer' }}>Pay Full Amount (₹{maxAmount.toLocaleString()})</button>
                                        </div>
                                    )}
                                    {errors.amount && <div style={{ color: '#ef4444', fontSize: '12px', marginTop: '4px' }}>{errors.amount}</div>}
                                </div>
                            </div>
                        </div>

                        <div style={{ display: 'flex', justifyContent: 'flex-end', gap: '16px', marginTop: '32px' }}>
                            <Link href={route('fees.index')} style={{ padding: '14px 28px', color: '#64748b', fontWeight: 700, textDecoration: 'none', fontSize: '15px' }}>
                                Cancel
                            </Link>
                            <button 
                                type="submit" 
                                disabled={processing || !data.amount || !data.fee_id} 
                                style={{ 
                                    padding: '14px 48px', background: '#5f259f', color: '#fff', 
                                    border: 'none', borderRadius: '12px', fontWeight: 800, fontSize: '15px',
                                    boxShadow: '0 10px 15px -3px rgba(95,37,159,0.3)', transition: 'all 0.2s',
                                    cursor: (processing || !data.amount || !data.fee_id) ? 'not-allowed' : 'pointer',
                                    opacity: (processing || !data.amount || !data.fee_id) ? 0.7 : 1
                                }}
                            >
                                {processing ? 'Connecting...' : 'Proceed to PhonePe'}
                            </button>
                        </div>
                    </form>

                    <div style={{ marginTop: '48px', textAlign: 'center' }}>
                        <div style={{ fontSize: '12px', color: '#94a3b8', marginBottom: '16px' }}>SECURED BY</div>
                        <div style={{ display: 'flex', justifyContent: 'center', gap: '24px', opacity: 0.5 }}>
                            <i className="bi bi-shield-lock" style={{ fontSize: '24px' }}></i>
                            <i className="bi bi-pci-card" style={{ fontSize: '24px' }}></i>
                            <i className="bi bi-bank" style={{ fontSize: '24px' }}></i>
                        </div>
                    </div>
                </div>
            </div>
        </LmsLayout>
    );
}
