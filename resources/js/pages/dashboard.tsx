import { Head } from '@inertiajs/react';
import { useState } from 'react';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import { dashboard } from '@/routes';
import 'filepond/dist/filepond.min.css';

export default function Dashboard() {
    const [insuranceCompany, setInsuranceCompany] = useState('GEICO');
    const [diagnosticType, setDiagnosticType] = useState('Cardiotech Diagnostics');

    const handleClear = () => {
        const form = document.querySelector('form');

        if (!form) {
            return;
        }

        form.reset();
        setInsuranceCompany('GEICO');
        setDiagnosticType('Cardiotech Diagnostics');
    };

    return (
        <>
            <Head title="Dashboard" />

            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
                <div className="rounded-2xl border border-sidebar-border/70 bg-background p-6 shadow-sm dark:border-sidebar-border">
                    <div className="mb-6">
                        <h1 className="text-2xl font-semibold tracking-tight">
                            Patient intake form
                        </h1>
                        <p className="text-sm text-muted-foreground">
                            Fill in the patient details and claim information.
                        </p>
                    </div>

                    <form
                        action="/dashboard/download-pdf"
                        method="post"
                        encType="multipart/form-data"
                        className="grid gap-6 rounded-3xl border border-border/60 bg-card p-6 shadow-lg shadow-black/5 md:grid-cols-2"
                    >
                        <div className="grid gap-2">
                            <Label htmlFor="cardio_tech">
                                Cardio Tech billing
                            </Label>
                            <Input
                                id="cardio_tech"
                                name="cardio_tech"
                                type="file"
                            />
                        </div>
                        <div className="grid gap-2">
                            <Label htmlFor="heart_health">
                                Heart Health billing
                            </Label>
                            <Input
                                id="heart_health"
                                name="heart_health"
                                type="file"
                            />
                        </div>

                        <div className="grid gap-2">
                            <Label htmlFor="patient_name">Patient name</Label>
                            <Input
                                id="patient_name"
                                name="patient_name"
                                placeholder="John Doe"
                                className="capitalize"
                                required
                            />
                        </div>

                        <div className="grid gap-2">
                            <Label htmlFor="diagnostic_type">
                                Diagnostic type
                            </Label>
                            <Select
                                value={diagnosticType}
                                onValueChange={setDiagnosticType}
                            >
                                <SelectTrigger
                                    id="diagnostic_type"
                                    className="w-full"
                                >
                                    <SelectValue placeholder="Select diagnostic type" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem value="Cardiotech Diagnostics">
                                        Cardiotech Diagnostics
                                    </SelectItem>
                                    <SelectItem value="Heart Health Diagnostics">
                                        Heart Health Diagnostics
                                    </SelectItem>
                                </SelectContent>
                            </Select>
                            <input
                                type="hidden"
                                name="diagnostic_type"
                                value={diagnosticType}
                            />
                        </div>

                        <div className="grid gap-2">
                            <Label htmlFor="date_of_accident">
                                Date of accident
                            </Label>
                            <Input
                                id="date_of_accident"
                                name="date_of_accident"
                                type="text"
                                placeholder="MM/DD/YYYY"
                                required
                            />
                        </div>

                        <div className="grid gap-2">
                            <Label htmlFor="date_of_signature">
                                Date of signature
                            </Label>
                            <Input
                                id="date_of_signature"
                                name="date_of_signature"
                                type="text"
                                placeholder="MM/DD/YYYY"
                                required
                            />
                        </div>

                        <div className="grid gap-2 md:col-span-2">
                            <Label htmlFor="address">Address</Label>
                            <Input
                                id="address"
                                name="address"
                                placeholder="123 Main Street"
                                className="capitalize"
                                required
                            />
                        </div>

                        <div className="grid gap-2">
                            <Label htmlFor="date_of_birth">Date of birth</Label>
                            <Input
                                id="date_of_birth"
                                name="date_of_birth"
                                type="text"
                                placeholder="MM/DD/YYYY"
                                required
                            />
                        </div>

                        <div className="grid gap-2">
                            <Label htmlFor="phone">Phone</Label>
                            <Input
                                id="phone"
                                name="phone"
                                placeholder="555 123 4567"
                                required
                            />
                        </div>

                        <div className="grid gap-2 md:col-span-2">
                            <Label htmlFor="claim">Claim</Label>
                            <Input
                                id="claim"
                                name="claim"
                                placeholder="Claim details"
                                required
                            />
                        </div>

                        <div className="grid gap-2">
                            <Label htmlFor="insurance_company">
                                Insurance company
                            </Label>
                            <Select
                                value={insuranceCompany}
                                onValueChange={setInsuranceCompany}
                            >
                                <SelectTrigger
                                    id="insurance_company"
                                    className="w-full"
                                >
                                    <SelectValue placeholder="Select insurance" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem value="GEICO">GEICO</SelectItem>
                                    <SelectItem value="PROGRESSIVE">
                                        PROGRESSIVE
                                    </SelectItem>
                                    <SelectItem value="ASSURANCE AMERICA INSURANCE">
                                        ASSURANCE AMERICA INSURANCE
                                    </SelectItem>
                                    <SelectItem value="ALL STATE INSURANCE">
                                        ALL STATE INSURANCE
                                    </SelectItem>
                                    <SelectItem value="STATE FARM INS">
                                         STATE FARM INS
                                    </SelectItem>
                                </SelectContent>
                            </Select>
                            <input
                                type="hidden"
                                name="insurance_company"
                                value={insuranceCompany}
                            />
                        </div>

                        <div className="grid gap-2">
                            <Label htmlFor="signature">Signature</Label>
                            <Input
                                id="signature"
                                name="signature"
                                placeholder="Type your name as signature"
                                className="capitalize"
                            />
                        </div>
                        <div className="grid gap-2">
                            <Label htmlFor="holter">Holter</Label>
                            <Input
                                id="holter"
                                name="holter"
                                type="file"

                            />
                        </div>
                        <div className="grid gap-2">
                            <Label htmlFor="mct">MCT</Label>
                            <Input
                                id="mct"
                                name="mct"
                                type="file"

                            />
                        </div>

                        <div className="flex justify-end gap-3 md:col-span-2">
                            <Button type="button" variant="outline" className="capitalize" onClick={handleClear}>
                                clean
                            </Button>
                            <Button className="capitalize" type="submit">
                                generate
                            </Button>
                        </div>
                    </form>
                </div>
            </div>
        </>
    );
}

Dashboard.layout = {
    breadcrumbs: [
        {
            title: 'Dashboard',
            href: dashboard(),
        },
    ],
};
