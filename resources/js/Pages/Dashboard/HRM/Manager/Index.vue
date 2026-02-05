<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Button } from '@/Components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/Components/ui/card';
import { Badge } from '@/Components/ui/badge';
import StatsCard from '@/Components/dashboard/StatsCard.vue';
import { Users, Briefcase, Calendar, TrendingUp } from 'lucide-vue-next';

defineProps({
    stats: {
        type: Object,
        default: () => ({
            totalEmployees: 0,
            activeRecruitments: 0,
            pendingLeaves: 0,
            attendanceRate: 0
        })
    }
});
</script>

<template>

    <Head title="HRM Manager Dashboard" />

    <AuthenticatedLayout>
        <div class="p-6">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-2xl font-bold">HRM Manager Dashboard</h1>
                    <p class="text-gray-600">Manage your HR team and operations</p>
                </div>
                <Badge variant="outline" class="text-sm">
                    Manager Access
                </Badge>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <StatsCard title="Total Employees" :value="stats.totalEmployees" icon="Users" color="primary" trend="up"
                    trendValue="+12%" />
                <StatsCard title="Active Recruitments" :value="stats.activeRecruitments" icon="Briefcase" color="blue"
                    trend="neutral" />
                <StatsCard title="Pending Leaves" :value="stats.pendingLeaves" icon="Calendar" color="orange" trend="up"
                    trendValue="+5" />
                <StatsCard title="Attendance Rate" :value="`${stats.attendanceRate}%`" icon="CheckCircle" color="green"
                    trend="up" trendValue="+3%" />
            </div>

            <!-- Quick Actions -->
            <Card class="mb-6">
                <CardHeader>
                    <CardTitle>Quick Actions</CardTitle>
                </CardHeader>
                <CardContent>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <Button variant="outline" as="a" :href="route('hrm.recruitment.create')">
                            <Briefcase class="h-4 w-4 mr-2" />
                            New Recruitment
                        </Button>
                        <Button variant="outline" as="a" :href="route('hrm.team.index')">
                            <Users class="h-4 w-4 mr-2" />
                            Manage Team
                        </Button>
                        <Button variant="outline" as="a" :href="route('hrm.reports.index')">
                            <TrendingUp class="h-4 w-4 mr-2" />
                            View Reports
                        </Button>
                        <Button variant="outline" as="a" :href="route('hrm.analytics.index')">
                            <BarChart class="h-4 w-4 mr-2" />
                            Analytics
                        </Button>
                    </div>
                </CardContent>
            </Card>
        </div>
    </AuthenticatedLayout>
</template>