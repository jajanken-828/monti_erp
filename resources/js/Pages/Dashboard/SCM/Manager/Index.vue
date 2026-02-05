<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { Button } from '@/Components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/Components/ui/card';
import { Badge } from '@/Components/ui/badge';
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/Components/ui/tabs';
import StatsCard from '@/Components/dashboard/StatsCard.vue';
import InventoryCard from '@/Components/scm/InventoryCard.vue';
import OrderTracking from '@/Components/scm/OrderTracking.vue';
import { Package, Truck, DollarSign, TrendingUp, AlertCircle, CheckCircle, BarChart } from 'lucide-vue-next';

defineProps({
    stats: {
        type: Object,
        default: () => ({
            totalInventory: 0,
            pendingOrders: 0,
            activeShipments: 0,
            lowStockItems: 0
        })
    },
    inventoryAlerts: {
        type: Array,
        default: () => []
    },
    pendingOrders: {
        type: Array,
        default: () => []
    },
    recentShipments: {
        type: Array,
        default: () => []
    },
    financialMetrics: {
        type: Object,
        default: () => ({})
    }
});
</script>

<template>

    <Head title="SCM Manager Dashboard" />

    <AuthenticatedLayout>
        <div class="p-6">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-2xl font-bold">SCM Manager Dashboard</h1>
                    <p class="text-gray-600">Manage your supply chain operations</p>
                </div>
                <div class="flex items-center space-x-2">
                    <Badge variant="outline" class="text-sm">
                        Manager Access
                    </Badge>
                    <Button>
                        <TrendingUp class="h-4 w-4 mr-2" />
                        Generate Report
                    </Button>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <StatsCard title="Total Inventory" :value="stats.totalInventory" :icon="Package" color="primary"
                    trend="up" trendValue="+5%" />
                <StatsCard title="Pending Orders" :value="stats.pendingOrders" :icon="Truck" color="orange" trend="up"
                    trendValue="+12" />
                <StatsCard title="Active Shipments" :value="stats.activeShipments" :icon="Truck" color="blue"
                    trend="down" trendValue="-3" />
                <StatsCard title="Low Stock Items" :value="stats.lowStockItems" :icon="AlertCircle" color="red"
                    trend="up" trendValue="+8" />
            </div>

            <!-- Tabs Navigation -->
            <Tabs default-value="overview" class="space-y-4">
                <TabsList>
                    <TabsTrigger value="overview">Overview</TabsTrigger>
                    <TabsTrigger value="inventory">Inventory</TabsTrigger>
                    <TabsTrigger value="orders">Orders</TabsTrigger>
                    <TabsTrigger value="logistics">Logistics</TabsTrigger>
                    <TabsTrigger value="financials">Financials</TabsTrigger>
                </TabsList>

                <!-- Overview Tab -->
                <TabsContent value="overview" class="space-y-4">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Left Column -->
                        <div class="lg:col-span-2 space-y-6">
                            <!-- Inventory Alerts -->
                            <Card>
                                <CardHeader>
                                    <CardTitle class="flex items-center justify-between">
                                        <span>Inventory Alerts</span>
                                        <Badge variant="destructive">{{ inventoryAlerts.length }}</Badge>
                                    </CardTitle>
                                </CardHeader>
                                <CardContent>
                                    <div class="space-y-4">
                                        <div v-for="alert in inventoryAlerts.slice(0, 5)" :key="alert.id"
                                            class="flex items-center justify-between p-3 border rounded">
                                            <div class="flex items-center space-x-3">
                                                <div class="bg-red-100 p-2 rounded">
                                                    <AlertCircle class="h-4 w-4 text-red-600" />
                                                </div>
                                                <div>
                                                    <p class="font-medium">{{ alert.item }}</p>
                                                    <p class="text-sm text-gray-500">Stock: {{ alert.stock }} units</p>
                                                </div>
                                            </div>
                                            <Badge variant="destructive">Critical</Badge>
                                        </div>
                                    </div>
                                    <Button variant="outline" as="a" :href="route('scm.inventory.alerts')"
                                        class="w-full mt-4">
                                        View All Alerts
                                    </Button>
                                </CardContent>
                            </Card>

                            <!-- Quick Actions -->
                            <Card>
                                <CardHeader>
                                    <CardTitle>Manager Actions</CardTitle>
                                </CardHeader>
                                <CardContent>
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                        <Button variant="outline" as="a" :href="route('scm.inventory.create')">
                                            <Package class="h-4 w-4 mr-2" />
                                            Add Inventory
                                        </Button>
                                        <Button variant="outline" as="a" :href="route('scm.orders.create')">
                                            <ShoppingCart class="h-4 w-4 mr-2" />
                                            Create Order
                                        </Button>
                                        <Button variant="outline" as="a" :href="route('scm.suppliers.create')">
                                            <Truck class="h-4 w-4 mr-2" />
                                            Add Supplier
                                        </Button>
                                        <Button variant="outline" as="a" :href="route('scm.reports.generate')">
                                            <FileText class="h-4 w-4 mr-2" />
                                            Generate Report
                                        </Button>
                                    </div>
                                </CardContent>
                            </Card>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-6">
                            <!-- Recent Shipments -->
                            <Card>
                                <CardHeader>
                                    <CardTitle>Recent Shipments</CardTitle>
                                </CardHeader>
                                <CardContent>
                                    <OrderTracking :shipments="recentShipments.slice(0, 3)" />
                                    <Button variant="outline" as="a" :href="route('scm.logistics.tracking')"
                                        class="w-full mt-4">
                                        Track All Shipments
                                    </Button>
                                </CardContent>
                            </Card>

                            <!-- Financial Snapshot -->
                            <Card>
                                <CardHeader>
                                    <CardTitle>Financial Snapshot</CardTitle>
                                </CardHeader>
                                <CardContent class="space-y-4">
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-600">This Month's Revenue</span>
                                        <span class="font-bold text-green-600">${{
                                            financialMetrics.revenue?.toLocaleString() || '0' }}</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-600">Pending Payments</span>
                                        <span class="font-bold text-orange-600">${{
                                            financialMetrics.pendingPayments?.toLocaleString() || '0' }}</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-600">Inventory Value</span>
                                        <span class="font-bold text-blue-600">${{
                                            financialMetrics.inventoryValue?.toLocaleString() || '0' }}</span>
                                    </div>
                                    <Button variant="outline" as="a" :href="route('scm.financials.details')"
                                        class="w-full">
                                        <DollarSign class="h-4 w-4 mr-2" />
                                        View Details
                                    </Button>
                                </CardContent>
                            </Card>
                        </div>
                    </div>
                </TabsContent>

                <!-- Inventory Tab -->
                <TabsContent value="inventory">
                    <Card>
                        <CardHeader>
                            <CardTitle>Inventory Management</CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <InventoryCard title="Total Items" :value="stats.totalInventory"
                                    description="Across all warehouses" color="primary" />
                                <InventoryCard title="Low Stock" :value="stats.lowStockItems"
                                    description="Requires attention" color="red" />
                                <InventoryCard title="Out of Stock" :value="0" description="Currently none"
                                    color="green" />
                            </div>
                        </CardContent>
                    </Card>
                </TabsContent>
            </Tabs>
        </div>
    </AuthenticatedLayout>
</template>