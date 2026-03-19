import LmsLayout from '@/Layouts/LmsLayout';
import { Head, useForm, Link } from '@inertiajs/react';

const cardStyle = {
    background: '#fff',
    borderRadius: '16px',
    boxShadow: '0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03)',
    padding: '32px',
    marginBottom: '24px',
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

const labelStyle = {
    display: 'block',
    fontSize: '13px',
    fontWeight: 700,
    color: '#475569',
    marginBottom: '8px',
    textTransform: 'uppercase',
    letterSpacing: '0.025em',
};

export default function AdmissionCreate({ auth, courses, batches }) {
    const { data, setData, post, processing, errors } = useForm({
        full_name: auth?.user?.name || '',
        email: auth?.user?.email || '',
        phone: '',
        course_id: '',
        batch_id: '',
        address: '',
        previous_education: '',
    });

    const allCourses = courses || [];
    const allBatches = batches || [];

    const filteredBatches = data.course_id
        ? allBatches.filter(b => b.course_id === parseInt(data.course_id))
        : [];

    const submit = (e) => {
        e.preventDefault();
        post(route('admissions.store'));
    };

    return (
        <LmsLayout title="Course Admission">
            <Head title="Apply for Admission - EduLMS" />
            
            <div className="row g-4">
                <div className="col-12 col-xl-8">
                    <div style={{ marginBottom: '32px' }}>
                        <h2 style={{ fontSize: '28px', fontWeight: 900, color: '#1e293b', marginBottom: '8px' }}>Start Your Journey</h2>
                        <p style={{ fontSize: '15px', color: '#64748b' }}>Complete the application form below to enroll in your desired course.</p>
                    </div>

                    {/* Step Indicator */}
                    <div style={{ display: 'flex', alignItems: 'center', gap: '12px', marginBottom: '32px', overflowX: 'auto', paddingBottom: '8px' }}>
                        {[
                            { label: 'Personal Details', icon: 'bi-person' },
                            { label: 'Academic Info', icon: 'bi-book' },
                            { label: 'Course Selection', icon: 'bi-check2-circle' }
                        ].map((step, i) => (
                            <div key={i} style={{ display: 'flex', alignItems: 'center', gap: '12px', flexShrink: 0 }}>
                                <div style={{ 
                                    display: 'flex', alignItems: 'center', gap: '8px', padding: '8px 16px', 
                                    borderRadius: '12px', background: i === 0 ? '#2563eb' : '#f8fafc',
                                    color: i === 0 ? '#fff' : '#64748b', border: i === 0 ? 'none' : '1px solid #f1f5f9'
                                }}>
                                    <i className={`bi ${step.icon}`} style={{ fontSize: '16px' }}></i>
                                    <span style={{ fontSize: '13px', fontWeight: 700 }}>{step.label}</span>
                                </div>
                                {i < 2 && <div style={{ width: '24px', height: '2px', background: '#f1f5f9' }}></div>}
                            </div>
                        ))}
                    </div>

                    <form onSubmit={submit}>
                        {/* Section 1: Personal */}
                        <div style={cardStyle}>
                            <h3 style={{ fontSize: '18px', fontWeight: 800, color: '#1e293b', marginBottom: '24px', display: 'flex', alignItems: 'center', gap: '12px' }}>
                                <div style={{ width: '36px', height: '36px', borderRadius: '10px', background: '#eff6ff', color: '#2563eb', display: 'flex', alignItems: 'center', justifyContent: 'center' }}>
                                    <i className="bi bi-person-fill"></i>
                                </div>
                                Personal Information
                            </h3>
                            <div className="row g-4">
                                <div className="col-md-6">
                                    <label style={labelStyle}>Full Name</label>
                                    <input 
                                        type="text" 
                                        value={data.full_name} 
                                        onChange={e => setData('full_name', e.target.value)} 
                                        required 
                                        style={inputStyle}
                                        placeholder="John Doe"
                                    />
                                    {errors.full_name && <div style={{ color: '#ef4444', fontSize: '12px', marginTop: '4px' }}>{errors.full_name}</div>}
                                </div>
                                <div className="col-md-6">
                                    <label style={labelStyle}>Email Address</label>
                                    <input 
                                        type="email" 
                                        value={data.email} 
                                        onChange={e => setData('email', e.target.value)} 
                                        required 
                                        style={inputStyle}
                                        placeholder="john@example.com"
                                    />
                                    {errors.email && <div style={{ color: '#ef4444', fontSize: '12px', marginTop: '4px' }}>{errors.email}</div>}
                                </div>
                                <div className="col-md-6">
                                    <label style={labelStyle}>Phone Number</label>
                                    <input 
                                        type="tel" 
                                        value={data.phone} 
                                        onChange={e => setData('phone', e.target.value)} 
                                        required 
                                        style={inputStyle}
                                        placeholder="+91 98765 43210"
                                    />
                                    {errors.phone && <div style={{ color: '#ef4444', fontSize: '12px', marginTop: '4px' }}>{errors.phone}</div>}
                                </div>
                                <div className="col-md-6">
                                    <label style={labelStyle}>Educational Background</label>
                                    <input 
                                        type="text" 
                                        value={data.previous_education} 
                                        onChange={e => setData('previous_education', e.target.value)} 
                                        style={inputStyle}
                                        placeholder="e.g. Bachelor of Technology"
                                    />
                                </div>
                                <div className="col-12">
                                    <label style={labelStyle}>Residential Address</label>
                                    <textarea 
                                        value={data.address} 
                                        onChange={e => setData('address', e.target.value)} 
                                        rows={3} 
                                        style={{ ...inputStyle, resize: 'none' }}
                                        placeholder="Enter your full mailing address"
                                    ></textarea>
                                </div>
                            </div>
                        </div>

                        {/* Section 2: Course Selection */}
                        <div style={cardStyle}>
                            <h3 style={{ fontSize: '18px', fontWeight: 800, color: '#1e293b', marginBottom: '24px', display: 'flex', alignItems: 'center', gap: '12px' }}>
                                <div style={{ width: '36px', height: '36px', borderRadius: '10px', background: '#fef3c7', color: '#d97706', display: 'flex', alignItems: 'center', justifyContent: 'center' }}>
                                    <i className="bi bi-mortarboard-fill"></i>
                                </div>
                                Course Selection
                            </h3>
                            <div className="row g-4">
                                <div className="col-md-6">
                                    <label style={labelStyle}>Choose Course</label>
                                    <select 
                                        value={data.course_id} 
                                        onChange={e => { setData('course_id', e.target.value); setData('batch_id', ''); }} 
                                        required 
                                        style={inputStyle}
                                    >
                                        <option value="">Select a course</option>
                                        {allCourses.map(c => <option key={c.id} value={c.id}>{c.title}</option>)}
                                    </select>
                                    {errors.course_id && <div style={{ color: '#ef4444', fontSize: '12px', marginTop: '4px' }}>{errors.course_id}</div>}
                                </div>
                                <div className="col-md-6">
                                    <label style={labelStyle}>Select Batch</label>
                                    <select 
                                        value={data.batch_id} 
                                        onChange={e => setData('batch_id', e.target.value)} 
                                        required 
                                        disabled={!data.course_id}
                                        style={{ ...inputStyle, opacity: !data.course_id ? 0.6 : 1 }}
                                    >
                                        <option value="">Select a batch</option>
                                        {filteredBatches.map(b => <option key={b.id} value={b.id}>{b.name}</option>)}
                                    </select>
                                    {errors.batch_id && <div style={{ color: '#ef4444', fontSize: '12px', marginTop: '4px' }}>{errors.batch_id}</div>}
                                </div>
                            </div>
                        </div>

                        <div style={{ display: 'flex', justifyContent: 'flex-end', gap: '16px', marginTop: '16px' }}>
                            <Link href={route('courses.index')} style={{ padding: '14px 28px', color: '#64748b', fontWeight: 700, textDecoration: 'none', fontSize: '15px' }}>
                                Cancel
                            </Link>
                            <button 
                                type="submit" 
                                disabled={processing} 
                                style={{ 
                                    padding: '14px 36px', background: '#2563eb', color: '#fff', 
                                    border: 'none', borderRadius: '12px', fontWeight: 800, fontSize: '15px',
                                    boxShadow: '0 10px 15px -3px rgba(37,99,235,0.3)', transition: 'all 0.2s',
                                    cursor: processing ? 'not-allowed' : 'pointer', opacity: processing ? 0.7 : 1
                                }}
                            >
                                {processing ? 'Processing...' : 'Submit My Application'}
                            </button>
                        </div>
                    </form>
                </div>

                {/* Sidebar */}
                <div className="col-12 col-xl-4">
                    <div style={{ ...cardStyle }}>
                        <h4 style={{ fontSize: '15px', fontWeight: 800, color: '#1e293b', marginBottom: '20px' }}>Why Join EduLMS?</h4>
                        <div style={{ display: 'flex', flexDirection: 'column', gap: '20px' }}>
                            {[
                                { icon: 'bi-rocket-takeoff', title: 'Accelerated Learning', desc: 'Our curriculum is designed to get you job-ready in weeks.' },
                                { icon: 'bi-headset', title: '24/7 Support', desc: 'Access to dedicated mentors and technical support.' },
                                { icon: 'bi-briefcase', title: 'Placement Assistance', desc: 'Expert guidance on resumes and interview prep.' },
                                { icon: 'bi-people', title: 'Global Community', desc: 'Connect with thousands of students worldwide.' },
                            ].map((item, i) => (
                                <div key={i} style={{ display: 'flex', gap: '16px' }}>
                                    <div style={{ width: '32px', height: '32px', borderRadius: '8px', background: '#f8fafc', border: '1px solid #f1f5f9', display: 'flex', alignItems: 'center', justifyContent: 'center', flexShrink: 0 }}>
                                        <i className={`bi ${item.icon}`} style={{ color: '#2563eb', fontSize: '14px' }}></i>
                                    </div>
                                    <div>
                                        <div style={{ fontSize: '14px', fontWeight: 700, color: '#1e293b', marginBottom: '2px' }}>{item.title}</div>
                                        <div style={{ fontSize: '12px', color: '#64748b', lineHeight: '1.5' }}>{item.desc}</div>
                                    </div>
                                </div>
                            ))}
                        </div>
                        
                        <div style={{ mt: '32px', pt: '24px', borderTop: '1px solid #f1f5f9', textAlign: 'center' }}>
                            <div style={{ fontSize: '13px', color: '#64748b', marginBottom: '16px' }}>Have any questions?</div>
                            <a href="#" style={{ display: 'flex', alignItems: 'center', justifyContent: 'center', gap: '8px', padding: '10px', background: '#f8fafc', border: '1px solid #f1f5f9', borderRadius: '10px', color: '#1e293b', textDecoration: 'none', fontSize: '13px', fontWeight: 700 }}>
                                <i className="bi bi-chat-dots-fill" style={{ color: '#2563eb' }}></i>
                                Chat with an Advisor
                            </a>
                        </div>
                    </div>

                    <div style={{ ...cardStyle, background: 'linear-gradient(135deg, #1e293b 0%, #0f172a 100%)', color: '#fff', border: 'none' }}>
                        <div style={{ display: 'flex', alignItems: 'center', gap: '12px', marginBottom: '16px' }}>
                            <div style={{ width: '40px', height: '40px', borderRadius: '50%', background: 'rgba(255,255,255,0.1)', display: 'flex', alignItems: 'center', justifyContent: 'center' }}>
                                <i className="bi bi-info-circle" style={{ color: '#3b82f6' }}></i>
                            </div>
                            <div style={{ fontSize: '14px', fontWeight: 800 }}>Next Steps</div>
                        </div>
                        <ol style={{ fontSize: '12px', color: '#94a3b8', paddingLeft: '18px', marginBottom: '0', display: 'flex', flexDirection: 'column', gap: '10px' }}>
                            <li>Review & Submit your application.</li>
                            <li>Our team will review your details within 24-48 hours.</li>
                            <li>You will receive an email for Fee Payment once approved.</li>
                            <li>After payment, get instant access to the course dashboard.</li>
                        </ol>
                    </div>
                </div>
            </div>
        </LmsLayout>
    );
}
